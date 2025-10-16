# Sunny Days Theme Audit

## Repository snapshot
- The repository only contains flat PHP, CSS, JS, and image files at the root of the theme; there are no `assets/`, `sections/`, `templates/`, or `inc/` directories even though the code expects them. 【405836†L3-L11】【305ec1†L1-L9】
- Core bootstrap lives in `functions.php`, Customizer hooks sit in `customizer.php` and `customizer-archives.php`, templating spans multiple `page-*.php`, `archive-*.php`, `single*.php`, and `section-*.php` files, and front-end styling/scripts are provided by `style.css`, `theme.css`, `skin-heights.css`, `tokens.css`, and `theme.js`. 【F:functions.php†L6-L307】【F:customizer.php†L3-L186】【F:customizer-archives.php†L3-L24】【F:page-about.php†L5-L123】【F:archive-project.php†L6-L84】【F:section-webinars.php†L1-L56】【F:style.css†L1-L98】【F:theme.css†L1-L109】【F:theme.js†L1-L34】

## Strengths observed
- The Customizer configuration covers homepage sections, global typography/spacing tokens, page heroes, and archive heroes with reusable helpers and proper sanitization callbacks for most inputs. 【F:customizer.php†L26-L183】【F:customizer-archives.php†L15-L24】
- Homepage partials pull Customizer copy and CPT content with defensive checks and shortcodes for embeds, giving editors control over hero, stats, projects, resources + social feed, webinars, volunteer CTA, partners, testimonials, team, updates, newsletter, and contact CTA. 【F:section-hero.php†L1-L14】【F:section-stats.php†L1-L21】【F:section-projects.php†L1-L27】【F:section-resources.php†L1-L39】【F:section-webinars.php†L1-L56】【F:section-volunteer.php†L1-L14】【F:section-partners.php†L1-L19】【F:section-testimonials.php†L1-L38】【F:section-team.php†L1-L20】【F:section-updates.php†L1-L26】【F:section-newsletter.php†L1-L24】【F:section-contactcta.php†L1-L11】
- Custom post types, meta boxes, activation routines, and the webinar registration handler are present and align with the described content model, including sanitation of incoming data and email notifications. 【F:functions.php†L146-L307】

## Critical issues (blockers)
1. **Missing directory structure breaks includes and asset loading.** `t4sd_render_home_sections()` and the activation hook include templates from `/sections/section-*.php` and `/templates/*.php`, and the enqueue routine loads files from `/assets/css|js/`. None of those directories exist, so homepage rendering, Customizer requires, asset enqueues, and template assignments fail out of the box. 【F:functions.php†L234-L268】【F:header.php†L15-L22】【F:style.css†L12-L60】【F:theme.css†L1-L75】【F:section-hero.php†L1-L14】【F:homepage.php†L1-L3】【405836†L3-L11】【305ec1†L1-L9】
2. **Customizer files are required from `inc/` but stored at the root.** `functions.php` calls `require get_template_directory().'/inc/customizer.php'`, which triggers a fatal error because the `inc/` directory is absent and the actual files sit alongside `functions.php`. 【F:functions.php†L250-L252】【405836†L3-L11】
3. **Theme activation assigns non-existent templates.** The activation routine sets `_wp_page_template` values like `templates/homepage.php`, yet the real templates (e.g., `homepage.php`, `page-volunteer.php`) live in the root. Pages created on activation will reference missing template files and render with the default template instead. 【F:functions.php†L255-L288】【F:homepage.php†L1-L3】【F:page-volunteer.php†L1-L16】
4. **Asset paths referenced in markup are wrong.** The header logo loads from `/assets/images/SunnyDaysLogo.png` and `style.css` imports `assets/css/tokens.css`, but the image and token file are in the theme root, so requests 404 unless the structure is reorganized. 【F:header.php†L15-L22】【F:style.css†L1-L20】【405836†L3-L11】

## High/medium risks
- The homepage section order still lists a `social` slug that has no matching partial, so the loop silently skips an expected section and leaves dead configuration controls. 【F:functions.php†L219-L247】
- `t4sd_team_meta_save()` updates metadata directly from `$_POST` without verifying nonces or user capabilities, enabling privilege escalation for lower roles able to trigger `save_post`. 【F:functions.php†L201-L216】
- `t4sd_register_webinar()` accepts arbitrary submissions, stores them as published posts, and emails without rate limiting or spam mitigation beyond a nonce; consider captcha or throttling if exposed publicly. 【F:functions.php†L290-L307】
- Newsletter and donate templates contain placeholder `action="#"` and `href="#"` links, preventing form submissions or payment integration until replaced. 【F:section-newsletter.php†L12-L21】【F:page-donate.php†L4-L14】
- Documentation is effectively absent (`README.md` only contains a title) and the existing `EVALUATION.md` claims directories (`assets/`, `sections/`, `inc/`) that are missing, risking future contributors overlooking the blockers above. 【F:README.md†L1-L1】【F:EVALUATION.md†L3-L34】【405836†L3-L11】

## Additional observations
- Archive templates provide search, pagination, and customizable hero copy consistent across post types. 【F:archive-project.php†L6-L84】【F:archive-webinar.php†L6-L85】
- Page templates for About and Contact integrate Customizer overrides and sensible fallbacks, but `page-landing.php` and `page-no-title.php` are empty files that should either be implemented or removed. 【F:page-about.php†L5-L123】【F:page-contact.php†L5-L60】【093ded†L1-L1】
- Front-end assets duplicate many rules between `style.css` and `theme.css`; once the directory structure is corrected, consider consolidating to reduce redundant CSS. 【F:style.css†L12-L98】【F:theme.css†L1-L109】

## Recommendations
1. Restore the expected directory layout (`assets/css`, `assets/js`, `assets/images`, `sections/`, `templates/`, `inc/`) or update all include/enqueue paths to match the flat structure before shipping.
2. Move `customizer.php` and `customizer-archives.php` into an `inc/` folder (or change the `require` paths) so the theme boots without fatal errors.
3. Adjust activation template assignments to the correct locations after fixing the structure to ensure seeded pages render properly.
4. Add nonce/capability checks to meta box saves and consider anti-spam measures for the public webinar registration endpoint.
5. Fill or remove placeholder templates and CTA links, and expand the README with setup instructions so integrators understand required steps.
