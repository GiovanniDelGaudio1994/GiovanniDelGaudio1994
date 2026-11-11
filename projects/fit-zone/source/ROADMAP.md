# Roadmap — FitZone

## v0.1 · Portfolio baseline
- [x] Source cleaned for publication, credentials removed
- [x] MySQL schema-only SQL with synthetic seed
- [x] Project README and GitHub lint workflow
- [ ] Functional installation and end-to-end tests with local MySQL

## v0.2 · Security hardening — branch `feature/security-hardening`
- [ ] Remove state changes over GET; add CSRF tokens
- [ ] Centralize remaining SQL queries with parameterized statements
- [ ] Authorize all profile and booking mutations
- [ ] Restore safe image upload (MIME, size, random names, no executable files)

## v0.3 · Reliability — branch `feature/booking-tests`
- [ ] Prevent double bookings with transactions
- [ ] Add PHPUnit or integration-test harness
- [ ] Fix and consolidate duplicated calendar pages
- [ ] Review route/URL mismatches

## v0.4 · Usability — branch `feature/responsive-ui`
- [ ] Improve mobile layouts and keyboard navigation
- [ ] Add local screenshots of actual UI
- [ ] Replace placeholder imagery with properly licensed originals

## v1.0 · Release candidate
- [ ] Full accessibility and security review
- [ ] Documentation of installation and maintenance
- [ ] Hosted demo after security hardening, with synthetic data only
