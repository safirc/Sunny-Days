# Küçük Berk AI-Studio **PRO** v1.2

Tam entegre **AI prodüksiyon**: Senaryo (OpenAI) → TTS (ElevenLabs) → Görsel (Runway CLI) → Montaj (ffmpeg) → Final MP4.

## Kurulum (macOS / Linux)
1) Python paketleri: `pip install -r requirements.txt`
2) ffmpeg kur:
   - macOS: `brew install ffmpeg`
   - Ubuntu: `sudo apt-get install ffmpeg`

3) Runway CLI kur ve giriş yap (gerekirse):
   - https://docs.runwayml.com/ → CLI yükle
   - `runway login` (API anahtarınla)
   - Test: `runway --help`

4) `.env.sample` dosyasını `.env` olarak çoğalt ve doldur: `cp .env.sample .env`
5) İlk üretim: `python berknew.py "Ep 6 – Wi-Fi Kesildi"`

## Klasör Yapısı
```
berk_ai_studio_pro/
├─ berknew.py
├─ requirements.txt
├─ .env.sample
├─ prompts/
│  ├─ script_prompt_tr.txt
│  └─ visual_prompt_salon.txt
├─ scripts/            # otomatik yazılacak
├─ outputs/
│  ├─ voices/
│  ├─ visuals/
│  ├─ edits/
│  └─ uploads/
└─ utils/
   └─ crashout_filter.txt
```

## Notlar
- **Gerçek görsel üretim** için Runway CLI gereklidir (veya kendi video gen aracını CLI ile bağlayabilirsin).
- ElevenLabs TTS için ücret/limit koşullarını kontrol et.
- OpenAI modeli ve endpoint'i `.env` ile değiştirilebilir.
