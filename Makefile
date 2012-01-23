%.css : %.less
	lessc $^ $@

all : style.css
