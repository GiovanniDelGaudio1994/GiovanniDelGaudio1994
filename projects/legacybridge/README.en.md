# LegacyBridge — Hardware Compatibility Lab

[🇮🇹 Italiano](README.md) · 🇬🇧 **English**

![LegacyBridge](https://raw.githubusercontent.com/GiovanniDelGaudio1994/forma-ai/main/portfolio/assets/projects/legacybridge-cover.svg)

**Old hardware. New possibilities.**

LegacyBridge is an independent hardware-compatibility research project exploring how older PCs can be diagnosed, documented and given a practical second life. The first real case study is an **HP 550 notebook from the 2008 generation**.

## Observed findings

| Component | Current evidence |
|---|---|
| CPU | Intel Core 2 Duo T5670, 1.80 GHz |
| x64 support | Confirmed at the CPU level |
| Installed operating system | Windows 10 Pro 1909, 32 bit, successfully booted |
| RAM | Approximately 3 GiB |
| Firmware | Legacy BIOS |
| Storage | SATA drive reporting “SSD 4TB”; real capacity unverified |
| Linux Live x64 | Still to be tested |
| Windows 11 | Not tested, not officially compatible |

We distinguish **measurements from assumptions**. As the Core 2 Duo lacks key modern CPU instructions, an installer requirement bypass does not magically enable Windows 11.

## Public and private scope

The public part is a small, original **read-only PowerShell diagnostic probe**, licensed under **GNU AGPL-3.0-only** with the complete license text. The experimental lab source is not published.

The probe does not modify disks, firmware or Windows, and it does not redistribute Microsoft binaries or modified operating systems.

## Project links

- [▶ Interactive demo — English](https://giovannidelgaudio.it/legacybridge-demo/en/)
- [Public open-core diagnostic probe and license](https://github.com/GiovanniDelGaudio1994/forma-ai/tree/main/projects/legacybridge/)
- [English technical README](https://github.com/GiovanniDelGaudio1994/forma-ai/blob/main/projects/legacybridge/README.en.md)

© 2026 Giovanni Del Gaudio. Independent experimental project; not affiliated with Microsoft, HP or Intel.
