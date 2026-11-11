# Security notes (portfolio release)

This is an **educational historical PHP/MySQL application**, not a production-ready service.

Already adjusted in public package:
- Removed hard-coded MySQL credentials and admin-password shortcut.
- Set connection parameters from environment variables and generic DB error messages.
- Removed real user/contact/payment/booking data from SQL distribution; schema only.
- Parameterized the login, registration and homepage contact-form queries.
- Disabled profile photo upload until proper validation and CSRF protection is implemented.
- Changed admin user/trainer deletions to POST with CSRF token.
- Excluded original media files of uncertain provenance and user-upload directories.

**Known issues to address before Internet deployment**:
- CSRF tokens on all state-changing operations (including GET-based delete/cancel actions).
- Prepared statements consistently across all CRUD endpoints; authorization and ownership checks.
- Thorough output HTML escaping and upload validation.
- Transactions/locking to avoid double booking; capacity enforcement and indexes.
- Password policy, login throttling, session cookie settings.
- Integration tests against an isolated DB, consistent routes, accessibility checks.

Do not expose this repo as a public web service until the above security work is complete.
To report issues contact the repository maintainer privately.
