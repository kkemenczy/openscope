#!/bin/bash
#Create .h from opensearch plugin
intltool-extract --type=gettext/xml ../glosar-search.xml.in

#Create pot
xgettext --add-comments --from-code utf-8 -o tm.pot ../*.php ../js/*.php --keyword=N_ ../*.h

#Clean up .h
rm ../glosar-search.xml.in.h

#Update translations
for lang in `ls -1 *po | cut -d . -f 1` ; do
	msgmerge -o $lang.po $lang.po tm.pot
done

# Create localized plugins, one per language
cd ..
intltool-merge -m -x po glosar-search.xml.in glosar-search.xml

#Install language support: po file and search plugin
if [ -n "$1" ]; then
	cd po
	if [ -s $1.po ]; then
		if [ ! -d ../locale/$lang/LC_MESSAGES ] ; then
			mkdir -p ../locale/$lang/LC_MESSAGES;
			
		fi
		msgfmt -o ../locale/$lang/LC_MESSAGES/tm.mo $lang.po
		echo "$lang.po installed"
		cp ../$1/glosar-search.xml ../glosar-search.xml
		echo "$lang translation of glosar-search will be used"
	else
		echo "No such po file: $1.po"
	fi
else 
	echo "To use one of the languages as default, run update-po.sh LL"
fi
