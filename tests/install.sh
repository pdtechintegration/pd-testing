#!/bin/bash
set -ev
CURRENT_FOLDER="$(basename "$(pwd)")"
TEST_PATH="$(pwd)"

if [ "tests" = $CURRENT_FOLDER ]; then
	echo "Retrieving wordpress trunk files...."
	svn co --quiet http://develop.svn.wordpress.org/trunk/ ./
	
	echo "copying the sample test file"
	cp wp-tests-config-sample.php wp-tests-config.php
	
	echo "Inserting travis-ci specific credentials for mysql"
	
	# sed works differently on osx than linux, detect if on travis and run correct command
	# further adding code sniffing on travis, have not tested on osx to include genericly
	if [ "$TRAVIS" = true ]; then
		sed -i -f sed_commands wp-tests-config.php
		
		# Install CodeSniffer for WordPress Coding Standards checks.
		git clone --quiet https://github.com/squizlabs/PHP_CodeSniffer.git /tmp/php-codesniffer
		# Install WordPress Coding Standards.
		git clone --quiet https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards.git /tmp/wordpress-coding-standards
		# Hop into CodeSniffer directory.
		cd /tmp/php-codesniffer
		# Set install path for WordPress Coding Standards
		# @link https://github.com/squizlabs/PHP_CodeSniffer/blob/4237c2fc98cc838730b76ee9cee316f99286a2a7/CodeSniffer.php#L1941
		./scripts/phpcs --config-set installed_paths ../wordpress-coding-standards
		# Hop into themes directory.
		cd "$TEST_PATH"
		# After CodeSniffer install you should refresh your path.
		phpenv rehash
		
	else
		sed -i ".bak" -f sed_commands wp-tests-config.php
		rm wp-tests-config.php.bak
	fi
else
	echo "Please execute from within the tests folder!"
fi
