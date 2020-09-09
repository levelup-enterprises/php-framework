# Getting started

1. Install vendor libraries ( _composer install_ )

2. Use the SRC -> config -> index file to set up your site information

3. Add your accessible pages to the templates directory

   - Router only allows page request to pages in templates directory
   - Source folder can be changed in config file

4. Add page content to templates/views
   - Add extension _.view.php_ to all content pages

# Structure

## ROOT

Basic project setup files are stored here.

- index.php

  - Initializes project with routes, sessions and pages

## Public

Store all public accessible content here.

- CSS

  - All styles are loaded through core.css

- Images
- JS

  - Include any custom js here

## SRC

All backend content is stored here.

- Config

  - Backend project setup code
  - Configure site info here
  - Store all sensitive data here
  - Includes database connection file

- Controllers
  Route controllers are stored here

  - Route (project router)

- Models
  Project class modules are stored here

  - Export

  Http

  - Request
  - Session

  Utilities

  - Browser
  - DB
  - Helper

## Templates

All view content is stored here.

\*All valid routes are established in this folder (EXCEPT for components & pages).

- Components
  Main site components are stored here.
  EX: footer, header...

  - Common
    Place reusable components here.

- Views
  All page specific content is rendered here.

  - View file and page file must have same name (View use example below)
  - All page data is prefixed with .page.php

  ### Basic Router Use:

  For every level down you go you must include a views directory to house rendered content.

  EX:

        templates/
          thankyou.php (accessible page)
          views/
            thankyou.view.php (page content)
          authorized/
            user.php (accessible page)
            views/
              user.view.php (page content)
            admin/
              index.php (accessible page)
              views/
                index.view.php (page content)

## Vendor

All vendor required files are stored here.

### Libraries

- AWS (texting)
- phpmailer (emails)
- thingengineer (db library shortcode)

## Happy building!
