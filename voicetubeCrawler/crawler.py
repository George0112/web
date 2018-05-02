import requests
from bs4 import BeautifulSoup
import json
from json import JSONDecodeError
import re
from pprint import pprint
import time
from browser import Browser
from time import sleep
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import StaleElementReferenceException
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from collections import defaultdict
import collections
from operator import itemgetter
from collections import OrderedDict

loginpath = "./login"
login_file = open(loginpath, 'r', encoding="utf-8")

file = open("videodata", 'w', encoding="utf-8")

if __name__ == '__main__':
    '''
    login_data = login_file.read()
    print(login_data)
    login = []
    login = re.split(' ',login_data)
    email = login[0]
    password = login[1]
    
    quote_page = "?order-type=time&order-time=newest&time=medium"
    base_url = "https://www.voicetube.com/all/"
    
    pageLevel = 3
    
    pageAccent = "&accent=us"
    accent = "US"'''
    
    browser = Browser()
    
    page = 1
    while page <= 30:
        #browser.get(base_url+str(pageLevel)+'/'+str(page)+quote_page+pageAccent)
        browser.get('https://www.voicetube.com/all/0'+'/'+str(page)+'?reco=1&ref=index_more_new&time=short-medium')
        
        pageSource = browser.driver.page_source
        response = BeautifulSoup(pageSource, "html.parser")
        
        #file.write("%s"%pageSource)
        
        ele_posts = []
        ele_posts = response.find_all("li", class_="span2")
        #ele_posts = browser.find('li.span2')
        #print(ele_posts)
        print("------------------------------")
        for index in range(len(ele_posts)):
            try:
                tags = ele_posts[index].select(".thumbnail-tags")
            except NoSuchElementException:
                pass
            #print(tags)
            
            basic = tags[0].select('.label-success')
            if basic: level = 'Basic'
            
            intermediate = tags[0].select('.label-info')
            if intermediate: level = 'Intermediate'
            
            advanced = tags[0].select('.label-inverse')
            if advanced: level = 'Advanced'
            
            print(level)
            
            accent = tags[0].select('.label-warning')
            if accent:
                accent = accent[0].text
            else:
                accent = 'NULL'
            
            print(accent)
            
            test = tags[0].select('.label-important')
            if test: test = 1
            else: test = 0
            print(test)
            
            time = ele_posts[index].select('.video-time')
            time = time[0].text
            print(time)
            
            title = ele_posts[index].select('.index-thumbnail-title')
            title = title[0].get('data-original-title')
            print(title)
            
            videoUrl = ele_posts[index].select('img.lazy')
            videoUrl = videoUrl[0].get('data-original')
            videoUrl = re.sub("https:\/\/cdn\.voicetube\.com\/assets\/thumbnails\/","",videoUrl)
            videoId = re.sub("_s.jpg$", "", videoUrl)
            print(videoId)
            
            print("index: %d"%index)
            r = requests.post("http://140.114.79.72/video/upload", data={'videoId': videoId, 'title': title, 'time': time, "level": level, "accent": accent, "test": test})
            print(r)
            
            print('===============================')
        page += 1
    browser.driver.quit()
