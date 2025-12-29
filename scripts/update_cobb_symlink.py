"""Updates the cobb symlink on metfs1:/data to point to latest data."""

from datetime import datetime, timezone
from pathlib import Path

import click


@click.command()
@click.option("--model", required=True, help="Model to generate links for.")
def main(model: str):
    """Go Main Go."""
    utcnow = datetime.now(timezone.utc)
    # Go figure out the most recent hour modulo 6
    hour = (utcnow.hour // 6) * 6
    symlink = Path("/data") / "cobb" / model
    dest = Path("/data") / "cobb" / f"{hour:02d}" / model
    if symlink.exists():
        symlink.unlink()
    symlink.symlink_to(dest)


if __name__ == "__main__":
    main()
