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
  - Link (connects project together)

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

\*All valid routes are established in this folder (EXCEPT for your components directory).

- Components
  Main site components are stored here.
  EX: footer, header...

  - Common
    Place reusable components here.

- Pages
  All page specific content is rendered here.

  - The directory name is the page name

    - **Requires an index page and view page to render correctly**

  - Nest additional directories to build out more complex structures.

  ### Basic Router Use:

  For every level down you go you must include a views directory to house rendered content.

  EX:

        templates/
          home/
            index.php (accessible page)
            view.php (page content)
          admin/
            index.php (accessible page)
            view.php (page content)
            users/
              index.php (accessible page)
              view.php (page content)
          404/
            index.php (accessible page)

## Vendor

All vendor required files are stored here.

### Libraries

- AWS (texting)
- phpmailer (emails)
- thingengineer (db library shortcode)

# Special Functions

## Authentication

- A random 20 bit token is generated on each new session.
- The token is stored as the session variable _auth_token_.
- All incoming request headers are compared with the token.

## AJAX Calls

- All ajax calls are only allowed access to the SRC root directory
  - Adjust the const **SCRIPTS** in the config file to change location.
  - All other files are off limit.
- All ajax calls are ran through header authentication automatically.

## Happy building!
