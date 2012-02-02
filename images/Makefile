sonnenblume-tiled.png : sonnenblume-flat.png
	convert $^ \( -clone 0 -roll \
		+0+`convert $^ -format "%[fx:round(h/2)]" info:` \
		\) +append $@
