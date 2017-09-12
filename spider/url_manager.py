#!D:\Python27\python.exe
#coding=utf8
#

class UrlManager ():
	def __init__ (self) :
		self.new_urls = set()
		self.old_urls = set()

	def add_new_url (self,url):
		if url is None:
			return
		if url not in self.new_urls and url not in self.old_urls:
			self.new_urls.add(url)

	def has_new_url (self) :
		if len(self.new_urls) > 0:
			return True
		return False

	def get_new_url (self) :
		if len(self.new_urls) > 0:
			new_url = self.new_urls.pop()
			self.old_urls.add(new_url)
			return new_url

	def add_new_urls (self,urls) :
		if len(urls) == 0 :
			return
		for url in urls :
			self.add_new_url(url)