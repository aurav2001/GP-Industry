=== GP-Industry ===
Contributors: gulshanpandey
Tags: blog, portfolio, one-column, two-columns, right-sidebar, custom-menu, custom-logo, featured-images, threaded-comments, translation-ready, block-styles, wide-blocks, editor-style
Requires at least: 6.3
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 2.9.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A modern WordPress theme for industrial, manufacturing and engineering companies — hero slideshow, products/services templates, 15 industrial block patterns and full block editor support.

== Description ==

GP-Industry is a lightweight classic theme with a premium look:

* Dark / light color scheme with a header toggle (remembers each visitor's choice) or "follow system" mode
* Customizable homepage: hero with auto-playing background image slideshow (up to 5 images, crossfade + Ken Burns zoom, overlay control), features grid, latest posts and a call-to-action banner
* Accent colors and corner radius controlled from the Customizer with live preview
* Dropdown menus (hover + keyboard + touch), off-canvas mobile navigation
* Search modal (press "/" to open), back-to-top button, reading progress bar on posts
* Post cards with categories, author, date and reading time
* Single posts: breadcrumbs, tags, share buttons, author box, previous/next, related posts
* Optional blog sidebar layout and 3 footer widget columns
* Social links in the footer
* Styles for every core Gutenberg block plus custom block styles (Gradient button, Card group, Highlight quote)
* Page templates: Products Page & Services Page (auto grid of child pages), Product Detail & Service Detail (sidebar with siblings, contact card, quote button), About Page (split hero), Contact Page (form card + contact info + Google Map), Full Width, Blank Canvas
* 15 industrial block patterns under "GP-Industry Sections": Hero, Products Grid, Services Grid, Industries We Serve, Our Process, Why Choose Us, Stats, Certifications & Clients, Product Specifications table, Projects Gallery, Testimonials, Leadership Team, FAQ, Quote banner, Request a Quote form section
* Homepage sections, all editable in the Customizer: hero slideshow, features, stats strip, about/intro (image + checklist + badge), products showcase (child pages), industries we serve, our process, testimonials, client/certification logos, FAQ, latest news, quote CTA
* Two header styles: floating glass "island" bar (default) or classic full-width; optional dismissible announcement bar
* Accessible: skip link, focus styles, ARIA on toggles, reduced-motion support
* Translation-ready (text domain: gp-industry)

== Setup ==

1. Appearance → Themes → Activate GP-Industry.
2. Appearance → GP-Industry Setup → "Import demo pages" — creates Home, About, Products (+3), Services (+3), Industries, Projects, Contact, News with designed sections, sets the front page and the menu. Then just edit the text. (Coming from another theme? "Repair templates" re-points pages that used the old theme's templates.)
2. Appearance → Menus → create a menu and assign it to "Primary Menu" (and optionally "Footer Menu").
3. Appearance → Customize → GP-Industry Options to set colors, hero text, features, CTA, blog layout, footer and social links.
4. Optional: Settings → Reading → set a static front page to use the landing page sections; set a "Posts page" so the "View all" link works.
5. Optional: Appearance → Widgets → add widgets to the Blog Sidebar and Footer Columns.

== Building pages ==

**Smart templates:** the Services, Products, About, Service/Product Detail and "Designed Sections (Auto)" templates
turn plain content into designed sections automatically — no patterns needed:
* H2 heading = new section title (a short line right before it becomes the small eyebrow label, the paragraph after it becomes the intro)
* H3 heading + paragraph = a card with an icon (add an image right after the H3 to get an image card). Several H3s in a row = card grid.
* Bulleted list = checklist grid
* Image = wide framed image
* Paragraphs only = split layout (heading left, text right)
Sections alternate a subtle background band. Block patterns, columns and groups pass through untouched.


1. Pages → Add New → in the right sidebar choose a Template (Services Page, About Page, Contact Page…).
2. Click the "+" inserter → Patterns tab → "GP-Industry Sections" and insert the sections you want. Edit text, duplicate columns to add more cards.
3. Services: create child pages (Page Attributes → Parent = your Services page). Give each a featured image, an excerpt (the description) and a bullet list in the content (the highlights) — each becomes a full image + text section on the Services page. Use the "Service Detail" template on those child pages.
4. Contact: fill Customize → GP-Industry Options → Contact Info. The Contact Page shows a built-in form automatically; paste a form plugin shortcode/block into the content to use that instead.

== Changelog ==

= 2.9.0 =
* Default content and demo import re-written for a corporate consultancy (staffing, payroll & compliance, housekeeping, security, facility management); company name is taken from Settings → General. All shared defaults now live in one place (gpi_option_defaults).

= 2.8.0 =
* Demo import now covers every template (adds Why Choose Us auto-layout demo, Training + 3 courses), generates placeholder images (hero slideshow, about image, featured images), fills sample contact details and appends pages to an existing menu. Child pages are detected by parent/slug so re-running never duplicates.

= 2.7.0 =
* Services Page redesigned as a modern landing page: trust strip, at-a-glance navigation, alternating image + text sections per service (featured image, excerpt, bullet highlights, buttons), then Process, Testimonials, FAQ (toggle in Customizer → Services Page: Sections).

= 2.6.0 =
* Built-in contact / quote form (no plugin needed) with honeypot spam protection; sends to Contact Info email or admin email.
* Courses Catalog and Course Detail page templates, fully styled, with quick enquiry form.

= 2.5.0 =
* 7 new homepage sections editable from the Customizer (About, Products, Industries, Process, Testimonials, Clients & Certifications, FAQ) with list fields using one item per line.

= 2.4.0 =
* Appearance → GP-Industry Setup: one-click demo page import (with menu + front page) and page-template repair for pages migrated from another theme.
* Old-theme page templates are re-mapped automatically on activation.

= 2.3.0 =
* Auto layout: smart templates convert plain headings/paragraphs/lists/images into designed sections and cards.
* New "Designed Sections (Auto)" page template.

= 2.2.0 =
* Repositioned as an industrial / manufacturing theme: new default copy, industrial icon set, Products & Product Detail templates, homepage stats strip, 15 industry patterns.

= 2.1.0 =
* Hero background image slideshow (Customize → Homepage: Hero Background Slider).
* New page templates: Services, Service Detail, About, Contact.
* 10 "GP-Industry Sections" block patterns.
* Redesigned floating header, announcement bar, animated menu icon, mobile drawer with header/close.
* Contact Info customizer section.


= 2.0.0 =
* Complete rebuild: light mode, customizer panel, search modal, dropdown menus, comments, sidebar, block styles, related posts, author box, breadcrumbs, page templates.

= 1.0.0 =
* Initial release.

== Credits ==

* Icons: hand-drawn SVG outlines inspired by Lucide (ISC License) and Simple Icons (CC0).
* Fonts: Outfit and Plus Jakarta Sans via Google Fonts (SIL Open Font License).
