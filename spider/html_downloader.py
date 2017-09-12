#!D:\Python27\python.exe
#coding=utf8
#

import urllib2

class HtmlDownloader () :
	def __init__ (self):
		pass

	def download(self,url) :
		if url is None :
			return None

		response = urllib2.urlopen(url)
		if response.getcode() != 200:
			return None
		cont = response.read()
		return cont