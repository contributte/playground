.PHONY: install qa cs csf phpstan

install:
	composer update

qa: phpstan cs

cs:
	vendor/bin/codesniffer app

csf:
	vendor/bin/codefixer app

phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon
