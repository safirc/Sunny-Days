#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Küçük Berk AI-Studio PRO v1.2
Senaryo (OpenAI) -> TTS (ElevenLabs) -> Görsel (Runway CLI) -> Edit (ffmpeg)
"""
import os
import json
import shlex
import subprocess
import sys
import time
from pathlib import Path

try:
    from dotenv import load_dotenv
except Exception:  # pragma: no cover - optional dependency
    load_dotenv = lambda *_args, **_kwargs: None

ROOT = Path(__file__).resolve().parent
load_dotenv(ROOT / ".env")

# --- ENV ---
OPENAI_API_KEY = os.getenv("OPENAI_API_KEY", "")
OPENAI_MODEL = os.getenv("OPENAI_MODEL", "gpt-4o-mini")
ELEVEN_API_KEY = os.getenv("ELEVEN_API_KEY", "")
VOICE_MAP_ENV = os.getenv("ELEVEN_VOICE_MAP", "")
RUNWAY_USE_CLI = os.getenv("RUNWAY_USE_CLI", "true").lower() == "true"
RUNWAY_PRESET = os.getenv(
    "RUNWAY_STYLE_PRESET",
    "cartoon-real hybrid, warm colors, Turkish living room, 9:16",
)
RUNWAY_DURATION = int(os.getenv("RUNWAY_DURATION", "30"))

# Paths
DIR_PROMPTS = ROOT / "prompts"
DIR_SCRIPTS = ROOT / "scripts"
DIR_OUT = ROOT / "outputs"
DIR_VOICES = DIR_OUT / "voices"
DIR_VISUALS = DIR_OUT / "visuals"
DIR_EDITS = DIR_OUT / "edits"
DIR_UPLOADS = DIR_OUT / "uploads"
for path in [DIR_SCRIPTS, DIR_VOICES, DIR_VISUALS, DIR_EDITS, DIR_UPLOADS]:
    path.mkdir(parents=True, exist_ok=True)

# Voice map
VOICE_MAP = {
    "Berk": "voice_berk",
    "Tunç": "voice_tunc",
    "Melis": "voice_melis",
    "Sevim": "voice_sevim",
    "Arda": "voice_arda",
}
if VOICE_MAP_ENV:
    try:
        VOICE_MAP = json.loads(VOICE_MAP_ENV)
    except json.JSONDecodeError:
        pass


def log(msg: str) -> None:
    print(f"[PRO] {msg}")


def slugify(text: str) -> str:
    text = text.lower()
    for src, tgt in {
        " ": "_",
        "-": "_",
        "/": "_",
        "ı": "i",
        "ş": "s",
        "ğ": "g",
        "ü": "u",
        "ö": "o",
        "ç": "c",
    }.items():
        text = text.replace(src, tgt)
    return "".join(ch for ch in text if ch.isalnum() or ch == "_")


# ---------- Step 1: Script (OpenAI) ----------
def gen_script(ep_title: str) -> Path:
    import requests

    prompt = (DIR_PROMPTS / "script_prompt_tr.txt").read_text(encoding="utf-8")
    user = f"Bölüm başlığı: {ep_title}\n{prompt}"
    headers = {
        "Authorization": f"Bearer {OPENAI_API_KEY}",
        "Content-Type": "application/json",
    }
    body = {
        "model": OPENAI_MODEL,
        "messages": [
            {"role": "system", "content": "You are a Turkish short-form comedy writer."},
            {"role": "user", "content": user},
        ],
        "temperature": 0.9,
    }
    response = requests.post(
        "https://api.openai.com/v1/chat/completions",
        headers=headers,
        json=body,
        timeout=90,
    )
    response.raise_for_status()
    content = response.json()["choices"][0]["message"]["content"]
    try:
        data = json.loads(content)
    except json.JSONDecodeError:
        import re

        match = re.search(r"(\{.*\})", content, re.S)
        if not match:
            raise RuntimeError("LLM JSON parse failed")
        data = json.loads(match.group(1))
    out_path = DIR_SCRIPTS / f"{slugify(ep_title)}.json"
    out_path.write_text(json.dumps(data, ensure_ascii=False, indent=2), encoding="utf-8")
    log(f"Senaryo yazıldı: {out_path.name}")
    return out_path


# ---------- Step 2: TTS (ElevenLabs) ----------
def make_voices(script_path: Path) -> Path:
    import requests

    data = json.loads(script_path.read_text(encoding="utf-8"))
    concat_list = DIR_EDITS / f"{script_path.stem}_concat.txt"
    concat_lines = []
    for idx, dialogue in enumerate(data["dialogues"]):
        speaker = dialogue.get("character", "Berk")
        text = dialogue.get("text", "")
        voice_id = VOICE_MAP.get(speaker, VOICE_MAP["Berk"])
        out_mp3 = DIR_VOICES / f"{script_path.stem}_{idx:02d}_{slugify(speaker)}.mp3"

        if ELEVEN_API_KEY:
            url = f"https://api.elevenlabs.io/v1/text-to-speech/{voice_id}"
            headers = {
                "xi-api-key": ELEVEN_API_KEY,
                "accept": "audio/mpeg",
                "Content-Type": "application/json",
            }
            body = {
                "text": text,
                "voice_settings": {"stability": 0.55, "similarity_boost": 0.9},
            }
            response = requests.post(url, headers=headers, json=body, timeout=90)
            response.raise_for_status()
            out_mp3.write_bytes(response.content)
        else:
            subprocess.run(
                shlex.split(
                    f"ffmpeg -f lavfi -i \"sine=frequency=880:duration=0.15\" -y {out_mp3}"
                ),
                check=True,
            )

        concat_lines.append(f"file '{out_mp3.as_posix()}'")

    concat_list.write_text("\n".join(concat_lines), encoding="utf-8")
    merged = DIR_EDITS / f"{script_path.stem}_merged.mp3"
    subprocess.run(
        shlex.split(
            f"ffmpeg -f concat -safe 0 -i {concat_list} -c copy -y {merged}"
        ),
        check=True,
    )
    log(f"TTS hazır: {merged.name}")
    return merged


# ---------- Step 3: Visual (Runway CLI) ----------
def render_visual(ep_title: str) -> Path:
    out_path = DIR_VISUALS / f"{slugify(ep_title)}.mp4"
    prompt = (
        DIR_PROMPTS / "visual_prompt_salon.txt"
    ).read_text(encoding="utf-8").strip().replace("\n", " ")
    title = ep_title.replace('"', "'")
    if RUNWAY_USE_CLI and cmd_exists("runway"):
        cmd = (
            "runway gen-video --prompt "
            f"\"{prompt}, {RUNWAY_PRESET}\" --duration {RUNWAY_DURATION} "
            f"--ratio 9:16 --output \"{out_path}\""
        )
        try:
            subprocess.run(cmd, shell=True, check=True)
            log(f"Görsel render tamam: {out_path.name}")
            return out_path
        except subprocess.CalledProcessError as exc:
            log(f"Runway CLI hata: {exc}")

    subprocess.run(
        shlex.split(
            "ffmpeg -f lavfi -i color=c=black:s=1080x1920:d="
            f"{RUNWAY_DURATION} -vf \"drawtext=text='{title}':"
            "fontcolor=white:fontsize=48:x=(w-text_w)/2:y=(h-text_h)/2\" "
            f"-c:v libx264 -pix_fmt yuv420p -y \"{out_path}\""
        ),
        check=True,
    )
    log(f"(Placeholder) Görsel oluşturuldu: {out_path.name}")
    return out_path


def cmd_exists(name: str) -> bool:
    try:
        subprocess.run(
            [name, "--help"],
            stdout=subprocess.DEVNULL,
            stderr=subprocess.DEVNULL,
            check=False,
        )
        return True
    except OSError:
        return False


# ---------- Step 4: Subtitles + Mux ----------
def build_srt(script_path: Path) -> Path:
    data = json.loads(script_path.read_text(encoding="utf-8"))
    srt_path = DIR_EDITS / f"{script_path.stem}.srt"
    current = 0.0
    lines = []
    for idx, dialogue in enumerate(data["dialogues"], start=1):
        text = dialogue.get("text", "")
        duration = max(0.8, min(4.0, len(text) / 12.0))
        start = fmt_ts(current)
        end = fmt_ts(current + duration + 0.2)
        lines.append(f"{idx}\n{start} --> {end}\n{dialogue['character']}: {text}\n")
        current += duration + 0.3
    srt_path.write_text("\n".join(lines), encoding="utf-8")
    return srt_path


def fmt_ts(seconds: float) -> str:
    hours = int(seconds // 3600)
    minutes = int((seconds % 3600) // 60)
    secs = int(seconds % 60)
    millis = int((seconds - int(seconds)) * 1000)
    return f"{hours:02d}:{minutes:02d}:{secs:02d},{millis:03d}"


def mux_all(video: Path, audio: Path, srt: Path, out_path: Path) -> None:
    overlay = (ROOT / "utils" / "crashout_filter.txt").read_text().strip()
    vf = f"{overlay},subtitles='{srt.as_posix()}'"
    cmd = (
        f'ffmpeg -i "{video}" -i "{audio}" -vf "{vf}" -map 0:v -map 1:a '
        f'-c:v libx264 -c:a aac -shortest -y "{out_path}"'
    )
    subprocess.run(cmd, shell=True, check=True)
    log(f"Final MP4: {out_path.name}")


# ---------- CLI ----------
def main() -> None:
    import argparse

    parser = argparse.ArgumentParser()
    parser.add_argument("title", help="Bölüm başlığı (örn. 'Ep 6 – Wi-Fi Kesildi')")
    args = parser.parse_args()
    ep_title = args.title

    if not OPENAI_API_KEY:
        print("UYARI: OPENAI_API_KEY boş. .env dosyasını doldurmalısın.")
    if not ELEVEN_API_KEY:
        print("UYARI: ELEVEN_API_KEY boş. TTS için doldur.")
    if RUNWAY_USE_CLI and not cmd_exists("runway"):
        print("UYARI: Runway CLI bulunamadı, placeholder video üretilecek.")

    script_path = gen_script(ep_title)
    audio_path = make_voices(script_path)
    video_path = render_visual(ep_title)
    srt_path = build_srt(script_path)
    final_out = DIR_UPLOADS / f"{slugify(ep_title)}_final.mp4"
    mux_all(video_path, audio_path, srt_path, final_out)
    log("Bitti ✅")


if __name__ == "__main__":
    main()
