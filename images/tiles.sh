#!/bin/bash

tile() {
	inkscape -z --export-background-opacity=0.0 --export-width=$1 --export-png=temp.png sonnenblume-flat.svg
	convert temp.png \( -clone 0 -roll \
		+0+`convert temp.png -format "%[fx:round(h/2)]" info:` \
		\) +append $2
	rm temp.png
}

tile 40 tiled-1x.png
tile 80 tiled-2x.png
