PROJECTS = $(sort $(dir $(wildcard ./*/.)))

update-all:
	@set -e; for d in ${PROJECTS}; do \
		composer update -d $${d} ; \
	done
