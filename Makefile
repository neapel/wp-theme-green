%.css : %.less
	lessc $^ $@

all : style.css

pot :
	php ../../i18n-tools/makepot.php wp-theme . languages/jan1.pot
