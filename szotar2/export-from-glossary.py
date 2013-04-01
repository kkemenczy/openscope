#!/usr/bin/env python
#Import libs
import polib
import fileinput
from time import gmtime, strftime

#Create po file from sracth
po = polib.POFile()
time = strftime("%Y-%m-%d %H:%M+0000", gmtime())
po.header='Translation of glossary'
po.metadata['Project-Id-Version'] = '1.0'
po.metadata['Report-Msgid-Bugs-To'] = 'you@example.com'
po.metadata['POT-Creation-Date'] = time
po.metadata['PO-Revision-Date'] = time
po.metadata['Last-Translator'] = 'Openscope <openscope@googlegroups.com>'
po.metadata['Language-Team'] = 'Openscope <openscope@googlegroups.com>'
po.metadata['MIME-Version'] = '1.0'
po.metadata['Content-Type'] = 'text/plain; charset=utf-8'
po.metadata['Content-Transfer-Encoding'] = '8bit'

#Read file line by line
for line in fileinput.input(['data/glosar.txt']):
	split_line=line.split('\t')
	split_msgstr=split_line[1].split(', ')
	for msgstr in split_msgstr:
		entry = polib.POEntry(msgid=split_line[0], msgstr=msgstr)
		po.append(entry)

po.save('hu-exported.po')
