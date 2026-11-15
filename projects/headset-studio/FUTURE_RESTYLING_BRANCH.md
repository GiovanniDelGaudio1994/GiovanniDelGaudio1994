# Future Liquid Glass restyling — work branch

This branch prepares the **next Headset Studio UI iteration**. It is documentation only, not Flutter application code.

## Current verified build (dark UI)

- Hardware used for tests: Marshall Major III Bluetooth on macOS.
- Verified in the project discussion: headset detection and Mac volume control.
- Two real macOS screen recordings are published at [Headset Studio demo](https://www.giovannidelgaudio.it/headset-studio-demo/).

## New design (not yet implemented in Flutter)

- [Original Liquid Glass mockup](https://www.giovannidelgaudio.it/headset-studio-demo/assets/headset-studio-liquid-glass.webp).
- Glassmorphism: bright pastel white/blue/lilac, transparent sidebar and widget cards, headphone visual on the right.
- Preserve the working macOS Bluetooth and volume logic; redesign the UI without swapping the data source.
- Show unknown battery/firmware data as unavailable rather than using the illustrative mockup values (90% / 0.0.0).
- Mark Audio Lab/equalizer as upcoming until actually implemented.
- Responsive macOS layout, keyboard accessibility, reduced-transparency fallback, and separate Windows testing.

## Next technical prerequisite

Connect or upload the actual Flutter source directory from the private Headset Studio Work project. Do not copy private source into this public profile repository. Once accessible, create `feature/liquid-glass-restyling` **inside the application's source repository** and implement with tests.

Related work: [Restyling plan](RESTYLING_PLAN.md).
