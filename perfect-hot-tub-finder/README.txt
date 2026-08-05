Perfect Hot Tub Finder
======================

Installation
------------
1. Upload perfect-hot-tub-finder.zip through WordPress Dashboard > Plugins > Add New > Upload Plugin.
2. Activate the plugin.
3. Edit a page with Elementor.
4. Search for "Spa Shop Slider" or open the "Hot Tub Finder" widget category.
5. Drag the widget onto the page.

Default Brand Settings
----------------------
Primary Color:   #00263D
Secondary Color: #85D9DE
Text:            #7A7A7A
Accent Color:    #00263D
White:           #FFFFFF
Text Color:      #1C1D1B
Border:          #E4E4E4
Font Family:     Questrial

Customizable Areas
------------------
- Header: breadcrumb, title, subtitle.
- Filters: show/hide Seating and Price, edit filter titles, add/remove filter options, and set each option's matching value.
- Products: manage products from Dashboard > Spa Models, or switch the widget to the Elementor Product Repeater for page-specific product data.
- Product fields: brand, series, rating, reviews, MSRP, seating, dimensions, jets, water care, product image, lifestyle background image, and button links.
- Style: global colors, typography, layout height, filter width, product/background image controls, button layout, and dedicated Primary Button / Secondary Button controls.

Notes
-----
This plugin uses the default Elementor/WordPress image placeholder when no image is selected. Replace each product image and lifestyle background for your live site.

Automatic Updates
-----------------
This plugin can update from GitHub releases in wpsoheltanvir/Hollywood-Plugin.

1. Increase the plugin version in perfect-hot-tub-finder.php, for example from 1.0.162 to 1.0.163.
2. Push the code to the main branch.
3. GitHub Actions will create the matching release tag and attach the install ZIP automatically.
4. WordPress will show the update from Dashboard > Updates or Plugins when the release version is newer.

For a private GitHub repository, add a fine-grained GitHub token with read-only repository Contents access to wp-config.php:

define( 'PHTF_GITHUB_TOKEN', 'github_pat_your_token_here' );


Changelog
---------
= 1.0.166 =
* Fixed tablet/mobile filter footer button clipping inside Elementor preview frames.

= 1.0.165 =
* Removed the extra tablet/mobile blank space caused by saved Elementor minimum-height styles.

= 1.0.164 =
* Fixed product image z-index and centered the product image in tablet/mobile layouts.

= 1.0.163 =
* Fixed the tablet/mobile filter drawer footer so Show Results and Reset Filters stay fully visible.

= 1.0.162 =
* Updated the GitHub release workflow so pushing code to main creates the WordPress update release automatically.

= 1.0.161 =
* Moved the plugin updater source to the wpsoheltanvir/Hollywood-Plugin GitHub repository.

= 1.0.160 =
* Added a GitHub Releases updater so WordPress can auto-detect new plugin versions.
* Added a GitHub Actions release workflow that builds the install ZIP when a version tag is pushed.
* Synced the internal plugin version constant with the public plugin header.

= 1.0.159 =
* Added a JavaScript viewport lock so the filter drawer fills tablet and mobile previews consistently.

= 1.0.158 =
* Forced the opened tablet/mobile filter drawer to fill the whole device preview instead of showing as a narrow side panel.

= 1.0.157 =
* Removed extra blank space below the tablet/mobile product buttons and hid the inner slider scrollbars.

= 1.0.156 =
* Removed tablet/mobile filter drawer scrollbars and fixed the sticky footer buttons so they fit inside the drawer.

= 1.0.155 =
* Made the tablet/mobile filter drawer full-screen across the viewport.

= 1.0.154 =
* Hid the lifestyle/background image in tablet and mobile slider layouts.
* Added tablet/mobile-only previous and next arrows beside the product image.
* Updated slider JavaScript so all visible arrow controls stay in sync.

= 1.0.153 =
* Rebuilt the Product & Background Images style section with simpler controls for product size, desktop/mobile product position, background crop, banner height, and curved shape.
* Removed extra advanced image controls that made responsive customization harder to manage.

= 1.0.152 =
* Added a safer Elementor widget loader so a missing optional widget file cannot crash the Elementor editor during an incomplete plugin upload.

= 1.0.151 =
* Improved responsive Style tab support so image, background, arrow, layout, and button controls continue working in tablet and mobile layouts.
* Connected the mobile filter drawer Show Results and Reset Filters buttons to the Primary Button and Secondary Button style controls.

= 1.0.150 =
* Increased the Price filter symbol and range text size for clearer tablet/mobile drawer display.

= 1.0.149 =
* Added editable Price Option range text so filters can show labels like $$$$ with "(Up to $10,999)" beside them.
* Styled price ranges for desktop, tablet, and mobile drawer layouts, including unavailable gray states.

= 1.0.148 =
* Added mobile/tablet filter drawer actions for Show Results and Reset Filters.
* Show Results closes the drawer with the current filters applied, while Reset Filters clears all filter selections and refreshes available options.

= 1.0.147 =
* Connected Seating and Price filters so unavailable options become disabled based on the other filter group.
* Added Caldera-style gray unavailable checkbox styling while keeping selected options easy to uncheck.

= 1.0.146 =
* Fixed the desktop/laptop classic slider layout so the lifestyle background image stays anchored to the full right side of the widget.
* Moved the product image back to the curved split area so it no longer overlaps the product text.

= 1.0.145 =
* Restored the requested Elementor global color palette: Primary #00263D, Secondary #85D9DE, Text #7A7A7A, Accent #00263D, White #FFFFFF, Text Color #1C1D1B, and Border #E4E4E4.
* Kept Questrial as the default font family across plugin widgets.

= 1.0.144 =
* Added a final Caldera-style responsive layout pass for desktop, laptop, tablet, phone, and small phone sizes.
* Kept desktop and wide laptop in the split shop layout with left filters/product copy and right lifestyle imagery.
* Switched tablet and phone layouts to a stacked full-width lifestyle banner with centered product image and slide-in filter drawer.
* Updated default image and banner sizing controls so new widgets start with responsive values closer to the reference shop.

= 1.0.143 =
* Updated the default Spa Shop Slider palette to match the reference shop style: gray headings/text with a coral accent for links, buttons, checkboxes, and arrows.
* Renamed the main Elementor widget to Spa Shop Slider.
* Added editable Seating Options and Price Options repeaters so filter labels and match values can be customized in Elementor.
* Changed repeater product filter fields to text inputs so custom filter values can be matched without code edits.

= 1.0.142 =
* Fixed activation by deferring Spa Model taxonomy setup and rewrite flushing to the normal WordPress init lifecycle.
* Kept the activation callback limited to safe setup flags.

= 1.0.141 =
* Fixed activation on newer Elementor versions by avoiding internal Elementor properties during plugin activation.
* Deferred Elementor global color setup until the normal WordPress admin lifecycle.

= 1.0.140 =
* Set the Spa Shop Slider desktop and laptop defaults requested for minimum height, filter width, product image sizing/positioning, and lifestyle background sizing/cutout.
* Removed the Spa Shop Slider Content Width control.
* Set the tablet/mobile lifestyle banner default height to 300px.
* Updated laptop container rules so Elementor responsive controls are not overridden by hard-coded image and filter widths.

= 1.0.139 =
* Fixed the laptop/Elementor-editor layout when the widget is inside a roughly 900–1100px-wide content area.
* Removed the hybrid responsive state that stacked the desktop filter column above the results while leaving desktop imagery active.
* Added a compact side-by-side laptop layout with narrower filters, results copy, specifications, and buttons.

= 1.0.138 =
* Unified the Spa Shop Slider responsive breakpoint with the 1024px filter-drawer JavaScript breakpoint.
* Added dedicated large-desktop, laptop, tablet, mobile, and extra-small layout rules.
* Prevented product text, filters, product images, and lifestyle images from overlapping at narrower widths.
* Made responsive Content Padding work consistently through the Elementor device controls.
* Added narrow Elementor-column protection using container queries.

= 1.0.137 =
* Fixed Series Comparison horizontal scrolling so row-spanned benefit groups no longer cause feature titles to slide into or appear over the Benefits column.
* Rebuilt sticky-column targeting with explicit Benefits and Features classes, opaque backgrounds, and corrected stacking order.
* Added responsive Table Header padding, text alignment, vertical alignment, wrapping, top-corner radius, sticky top-offset, and border controls.

= 1.0.136 =
* Removed the two discontinued Elementor widgets and all of their dedicated PHP, CSS, JavaScript, registration, and editor-hook code.

= 1.0.135 =
* Added editable breadcrumb labels, links, item ordering, add/remove controls, and an Active / Current switch for each item.
* Preserved existing Home / Current breadcrumb labels through a legacy-data fallback so current Elementor widgets do not lose their saved breadcrumb text.
* Added proper linked-item rendering and aria-current support for the active breadcrumb.

= 1.0.134 =
* Removed the extra tablet/mobile gap between the subtitle and results navigation.
* Rebuilt the tablet/mobile product visual as a full-width lifestyle-image banner with the product image centered over it.
* Added a responsive Tablet / Mobile Banner Height style control and preserved the existing background size, position, repeat, radius, opacity, and overlay controls.

= 1.0.132 =
* Fixed Spa Model backend placeholder handling so manually entered values remain saved and placeholders only appear when a field is empty.

= 1.0.131 =
* Auto-fill Spa Model Compare URL using the site compare page and the generated Compare Model ID, and updated the backend instruction text for the Compare URL field.

= 1.0.130 =
* Removed Seating Capacity from the Compare Specifications backend section. Seating Capacity remains available only in Spa Shop Slider Product Details.

= 1.0.129 =
* Removed Seating Capacity from Compare Specifications data/labels while keeping the main Spa Shop Slider Product Details seating field.

= 1.0.128 =
* Removed automatic creation of the Cantabria, Geneva, and Niagara starter Spa Model posts. Spa Models are now manual-only.

= 1.0.127 =
* Added automatic starter Spa Model creation for Cantabria®, Geneva®, and Niagara® when the Spa Models list is empty, so the comparison widget has the three default models available after plugin install/update.

Version 1.0.1: Added dedicated Elementor style controls for Primary Button and Secondary Button, including normal/hover tabs and button positioning controls.


== Changelog ==


= 1.0.126 =
* Removed the duplicate Seating Capacity field from the Compare Specifications backend meta box. The compare/specification output can still use the main Seating Capacity field from Spa Shop Slider Product Details.

= 1.0.125 =
* Added automatic seeding for the three starter Spa Model posts: Cantabria, Geneva, and Niagara, with Utopia Series compare/specification data.

= 1.0.124 =
* Renamed the Spa Model backend field from Compare Page spaID / Model ID to Compare Model ID.

= 1.0.123 =
* Added clear Compare URL backend instructions showing how to append the auto-generated spaID / Model ID, with a dynamic example URL for each Spa Model.

= 1.0.122 =
* Removed the Model Title Link URL field from the Spa Model backend and disabled CPT model-title linking in the Spa Shop Slider.

= 1.0.121 =
* Renamed the Spa Model backend field label from Get Local Pricing to Get Local Pricing URL.

= 1.0.120 =
* Updated Spa Model backend fields: Seating Capacity is now a 1 Adults through 15 Adults dropdown, Price Tier labels include full price ranges, and Local Pricing URL is renamed to Get Local Pricing URL.

= 1.0.119 =
* Moved the Spa Model backend price footnote popup text fields directly under their related Price / MSRP and Monthly / Second Price fields, while keeping price footnote link fields removed from the backend form.

= 1.0.118 =
* Removed Price Footnote Link URL and Price Footnote Link 2 URL fields from the Spa Model backend Product Details form while keeping footnote popup text fields active.

= 1.0.117 =
* Moved Reviews Link URL directly after Reviews Count in the Spa Model backend product details layout.

= 1.0.116 =
* Renamed the Spa Model backend brochure field to Download Brochure Link.
* Kept price footnote link fields blank by default with # used only as placeholder guidance.

= 1.0.115 =
* Changed the Spa Model price footnote URL fields so # is only placeholder text, not an auto-filled saved value. Existing # values are treated as empty.

= 1.0.114 =
* Removed Owner Manual URL, Review Quote, Review Author, and the image instruction note from the Spa Shop Slider Product Details backend box.

= 1.0.113 =
* Made the Spa Model Compare Model ID auto-generated, read-only, and unique for each Spa Model. Empty or duplicate IDs are automatically replaced with a unique ID when saved.

= 1.0.112 =
* Removed Product Image URL and Background / Lifestyle Image URL from the Spa Model backend Product Details box; use Featured Image and the sidebar Background / Lifestyle Image upload box instead.

= 1.0.111 =
* Strengthened Spa Model backend placeholder handling so all sample/detail text, including long popup examples and compare specification examples, is treated as placeholder content instead of real saved data.

= 1.0.110 =
* Changed all Spa Model backend product detail and compare specification sample values into placeholders so new posts start blank.

= 1.0.109 =
* Changed Spa Model backend sample values for Reviews Count, Price/MSRP, and Monthly/Second Price into placeholders instead of auto-filled values; legacy sample values are treated as empty so they no longer appear as real data.

= 1.0.108 =
* Hid the monthly/second price in the Hollywood Spa Shop Slider by default and added a widget toggle to show it only when needed.

= 1.0.107 =
* Removed bundled fallback images and switched missing image defaults back to the standard Elementor/WordPress image placeholder.

= 1.0.106 =
* Updated the Spa Shop Slider Background / Lifestyle Image defaults to 60% width, 100vh height, centered cover image, no-repeat, transparent overlay, visible curved cutout, 280px curve width, and -50px curve offset.

= 1.0.105 =
* Updated Spa Shop Slider Product Image style defaults: width 300px, max width 300px, height 30vh, right position 40%, vertical position 50%, horizontal offset 50%, vertical offset -50%, radius 15px, opacity 1, and z-index 25.

= 1.0.104 =
* Set the Spa Shop Slider Slide Arrows controls to the requested defaults: 18px gap, 20px icon size, 25px box size, and 5px border radius.

= 1.0.103 =
* Fixed the Spa Shop Slider Background / Lifestyle Image Height control so custom pixel, vh, and percent heights apply correctly on desktop and stay vertically centered.

= 1.0.102 =
* Updated the Spa Shop Slider MSRP and monthly/second price color default to use the Text global color (#7A7A7A) instead of the Secondary accent color.

= 1.0.101 =
* Renamed the WordPress plugin display name to Hollywood Outdoor Living for Elementor.

= 1.0.100 =

= 1.0.99 =
* Applied Elementor Global Color defaults across all plugin widgets and fixed misplaced global color metadata in widget controls.

= 1.0.98 =
* Updated Elementor color controls to use Hollywood Global Color tokens by default, so the controls auto-link to Primary, Secondary, Text, White, Text Color, and Border where applicable.

= 1.0.97 =
* Locked the Spa Shop Slider right-side lifestyle/background image to the full slider area on desktop/laptop so it stays in the same position between Elementor preview and the live page.

= 1.0.96 =
* Added automatic Elementor Global Colors setup for the Hollywood brand palette on plugin activation/update: Primary #00263D, Secondary #85D9DE, Text #7A7A7A, Accent #00263D, White #FFFFFF, Text Color #1C1D1B, and Border #E4E4E4.

= 1.0.95 =
* Replaced the H.O.L widget-name prefix with Hollywood for all Elementor widgets.

= 1.0.94 =
* Added the Hollywood prefix to all Elementor widget display names.

= 1.0.93 =
* Added a right-sidebar Background / Lifestyle Image upload box for Spa Models, connected to the Spa Shop Slider background image, and renamed the URL field as an optional fallback.

= 1.0.92 =
* Made the full Spa Shop Slider left-side area vertically centered by default on desktop/laptop and fixed the alignment breakpoint so the Left Area Position control works across desktop editor widths.

= 1.0.91 =
* Restored the Spa Shop Slider Data Source selector with both Spa Model Posts and Elementor Product Repeater options. Repeater mode now fully supports the monthly/second price and second footnote popup fields again.

= 1.0.90 =
* Added the Compare Specifications meta box back to the Spa Models backend edit screen.

= 1.0.89 =
* Added backend Spa Model fields for Monthly / Second Price Text, Price Footnote Link 2 URL, and Price Footnote Popup Text 2. Spa Shop Slider now displays the backend second price inline with “or” and supports the ² popup from Spa Models.

= 1.0.88 =
* Removed the large Edit with Elementor/editor area from Spa Model edit screens while keeping the title and permalink controls.

= 1.0.87 =
* Removed the Compare Specifications meta box from the Spa Models backend edit screen, keeping specifications handled through the Elementor Spa Model Specifications widget/addon instead.

= 1.0.86 =
* Fixed the Spa Shop Slider Left Area Position control so Top, Center, and Bottom align the full left-side area using flex alignment, and the custom offset now fine-tunes the full block.

= 1.0.85 =
* Rebuilt the Spa Shop Slider product source around the Spa Models post type, hiding the old Elementor product repeater UI and using Dashboard > Spa Models as the primary backend product manager.
* Updated the Spa Model admin fields to mirror the slider product fields, including price, seating, filters, product/lifestyle image URLs, buttons, reviews, and price footnote popup content.

= 1.0.84 =
* Renamed the Spa Shop Slider image style section to Product & Background Images.

= 1.0.83 =
* Removed the extra Product Image style section from the Spa Shop Slider Elementor style panel.

= 1.0.82 =
* Set the Spa Shop Slider left-side content area to center vertically by default and updated the Left Area Position controls to move the full left area using a CSS variable.

= 1.0.81 =
* Renamed the Spa Shop Slider image style section from Product & Background Images to Background Images.

= 1.0.80 =
* Updated the Spa Shop Slider left-area position controls so Top, Center, Bottom, and custom offset move the full left content area together, including filters, results navigation, product details, and buttons.

= 1.0.79 =
* Added Elementor layout controls for the Spa Shop Slider left product content vertical position, including Top, Center, Bottom, and a custom offset fine-tuning slider.

= 1.0.78 =
* Increased the Spa Shop Slider lifestyle/background image area on desktop so the right-side hero image fills more space.

= 1.0.77 =
* Removed the second price output and the second-price/second-footnote editor fields from the Spa Shop Slider, keeping only the main MSRP and primary footnote options.

= 1.0.76 =
* Changed the Spa Shop Slider mobile/tablet filter drawer headings to plain non-dropdown headings and removed the Seating and Price chevron icons.

= 1.0.75 =
* Replaced the Seating and Price drawer heading icons with a true CSS chevron that matches the clean Back button style more closely.

= 1.0.74 =
* Restored clean chevron-style icons for the Seating and Price headings in the Spa Shop Slider mobile/tablet filter drawer, replacing the plain caret characters with a back-button-style chevron icon.

= 1.0.73 =
* Removed the Seating and Price chevron icons from the Spa Shop Slider tablet/mobile filter drawer and aligned the filter headings cleanly without icons.

= 1.0.72 =
* Added Elementor color controls for the Spa Shop Slider tablet/mobile filter drawer, including filter button, drawer background, top bar, Back button, headings, hover/focus colors, chevrons, dividers, checkboxes, price accents, and price note text.

= 1.0.71 =
* Strengthened the Spa Shop Slider mobile/tablet drawer hover and focus styling so Seating, Price, chevrons, and Back use the brand accent color without any red or pink background highlight from theme/editor styles.

= 1.0.70 =
* Updated the Spa Shop Slider mobile/tablet drawer so the Seating and Price headings, chevrons, and Back button use the brand accent color on hover and focus.

= 1.0.68 =
* Fixed the Spa Shop Slider tablet/mobile filter drawer to use the correct mobile breakpoint, preserved the normal desktop/laptop layout, and refined the drawer styling to match the brand colors.

= 1.0.67 =
* Restricted the slide-in filter drawer to tablet/mobile breakpoints and restored the normal desktop/laptop left-side filter layout.

= 1.0.66 =
* Bundled fallback product, lifestyle/background, and widget images inside the plugin assets so missing images still display after plugin upload.
* Updated Spa Shop Slider, Spa Model post data, and widget defaults to use bundled fallback assets instead of Elementor placeholder images.

= 1.0.65 =
* Added editable Header controls for the Spa Shop Slider, including show/hide header, optional breadcrumb, title, and subtitle fields.

= 1.0.64 =
* Kept the Spa Shop Slider desktop filter layout unchanged while keeping the slide-in filter drawer behavior for tablet and mobile only.

= 1.0.63 =
* Added a branded slide-in filter drawer for tablet and mobile in the Spa Shop Slider, with a Filter button, Back close button, collapsible filter groups, and inline price info content.

= 1.0.62 =
* Added brand-friendly style controls for the Price Info Popup title, body text, accent/bold text, and popup typography.
* Updated detached price info popups to preserve brand colors while floating above the page.

= 1.0.61 =
* Updated plugin defaults to use the brand style: Questrial font, primary #00263D, secondary #85D9DE, and text #7A7A7A across the Spa Shop Slider and comparison styling.

= 1.0.60 =
* Added a custom icon picker for the Spa Shop Slider price info icon, allowing icon selection in the Filters content settings while keeping Elementor style controls for size and colors.

= 1.0.59 =
* Added Elementor style controls for the Spa Shop Slider price info icon, including size, font size, color, border color, background, and hover colors.

= 1.0.58 =
* Refined the Spa Shop Slider price info icon styling to better match the reference design, including size, color, alignment, and heading spacing.

= 1.0.57 =
* Added visible bottom scrollbar styling and Elementor controls for scrollbar height and colors in the Hot Tub Series Comparison widget.

= 1.0.56 =
* Added a hover popup option for the Price info icon in the Spa Shop Slider, with editable popup title and content managed in the widget settings.

= 1.0.55 =
* Added an easy Table Alignment control for the Hot Tub Series Comparison widget so the comparison table can be set to Left, Center, or Right.
* Centered the comparison table by default and added helper text for managing table width/minimum width.
* Added quick body alignment controls for Feature cells and Series cells.

= 1.0.54 =
* Added automatic superscript styling for ®, ™, and ℠ marks across all Perfect Hot Tub Finder widgets, including dynamically rendered widget content.

= 1.0.52 =
* Changed price footnote popups to fixed overlay positioning so hovering ¹ or ² does not shift/move the Spa Shop Slider layout.
* Stopped changing slider/container overflow while the detached popup is open.

= 1.0.51 =
* Smoothed price footnote hover popup behavior so superscript ¹/² popups stay open without flashing while moving between marker and popup.

= 1.0.50 =
* Changed price footnote popups to always open underneath the ¹ and ² superscript markers.
* Switched detached popups to document-level absolute positioning so long auto-height text can continue over lower page sections without flipping above the price line.

= 1.0.49 =
* Stabilized price footnote popup hover behavior so the popup no longer flashes or dances while hovering superscript ¹ and ² markers.
* Stabilized the ¹ and ² price footnote hover popups so they no longer flicker or jump when moving between the superscript marker and the popup.
* Changed detached footnote popups to fixed viewport positioning with throttled repositioning to prevent dancing on hover.
* Increased hover-close delay and added click-lock behavior for easier reading of long popup text.

= 1.0.47 =
* Changed price footnote popups to detach to the page body while open so they can display above any Elementor section, slider, tab bar, or container.
* Updated footnote popups to use natural auto height instead of clipping long financing/legal text.
* Increased the default popup width for a cleaner full-text layout.

= 1.0.46 =
* Fixed long price footnote popups being clipped by the slider container.
* Added popup width and max-height controls under Style > Price Text & Footnotes.
* Added safe popup scrolling for very long ¹ and ² financing/legal text.

= 1.0.45 =
* Added Elementor Style controls for price value color and footnote marker color/size/position.
* Set default footnote marker color for ¹ and ² to #85D9DE.

= 1.0.44 =
* Remade Spa Shop Slider post sourcing around the existing Spa Model Posts data source.
* Added Spa Model post fields for Monthly / Second Price, Price Footnote Link 2, and both price footnote popup texts so slider content can be managed from Spa Models instead of the Elementor repeater.


= 1.0.2 =
* Removed the Header content controls from the Elementor editor panel while keeping the default header display intact.

= 1.0.3 =
* Updated the highlighted product text elements to use the Primary color and bold font weight by default, including brand, series, MSRP, specification labels, and Water Care label.

= 1.0.4 =
* Updated tablet and mobile filter layout so Seating and Price display as two columns.

= 1.0.5 =
* Added dedicated Style tab controls for Brand / Model and Series text color, font style, and bottom spacing.

= 1.0.6 =

= 1.0.7 =
* Split the Filters content controls into separate Seating Filter and Price Filter groups.
* Added repeater controls so seat labels and price labels can be added, removed, and renamed.
* Added optional custom product filter values so new filter options can match specific products.
Version 1.0.8: Updated Layout control defaults to Minimum Height 600px, Content Width 100%, zero Content Padding, Filter Column Width 200px, Product Image Width 350px, and centered Hero Image Position.

= 1.0.9 =
* Added a Header show/hide switcher to hide or show the complete header area, while keeping breadcrumb, title, and subtitle controls available when enabled.

= 1.0.10 =
* Updated the responsive product layout so the product image is positioned over the lifestyle/background image instead of below the product copy.


= 1.0.11 =
* Added global show/hide controls for Product Image and Background/Lifestyle Image.
* Added a dedicated Product & Background Images style section with width, max-width, positioning, offsets, border radius, opacity, z-index, box shadow, background size, repeat, overlay color/opacity, and curved cutout controls.

- Product image displays as a square by default with customizable image fit.

= 1.0.13 =
* Removed the Hot Tub Series Comparison Elementor widget.

= 1.0.17 =
* Added dynamic Explore Our Models carousel using the same product repeater from the Hot Tub Finder widget.

= 1.0.18 =
* Added Explore Our Models as a separate Elementor widget.
* The separate widget pulls products dynamically from the Perfect Hot Tub Finder widget when both use the same Product Source ID.
* Products added/removed in the Hot Tub Finder product repeater automatically affect the Explore Our Models widget on the same page.

= 1.0.19 =
* Added Customize Spa Colors Elementor widget.
* Includes editable title, subtitle, spa preview image, cabinet swatches, shell swatches, cover colors text, info icon, and button.
* Added full style controls for palette, typography, layout, image, swatches, active states, divider, and button.

= 1.0.22 =
* Added Spa Series Models Elementor widget.
* Includes editable series model cards, images, ratings, review counts, seats, MSRP, optional links/buttons, and full color, typography, grid, card, image, text, button, and responsive controls.

= 1.0.27 =
* Removed Breadcrumb Home, Breadcrumb Separator, Breadcrumb Current, and Show Breadcrumb controls from the Perfect Hot Tub Finder Header panel.


= 1.0.31 =
* Made spa widgets pull dynamic content from the Spa Models custom post type when models are available. Spa Series Delight stays manually editable with its Elementor repeater.
* Added extra Spa Model fields for brochure links, local pricing, owner manuals, reviews, and feature slides.

= 1.0.33 =
* Renamed the Perfect Hot Tub Finder Elementor widget display name to Spa Shop Slider.

= 1.0.43 =
* Fixed MSRP / Price Text and Monthly / Second Price Text values to display in #85D9DE.

= 1.0.42 =
* Changed the Product Results repeater Series field from text input to a dropdown with Utopia®, Paradise®, Vacanza®, and Fantasy™ series choices.
