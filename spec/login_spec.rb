#!/bin/env ruby
# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'ログインページ', :js => true do
    it 'ログインページにアクセスする' do
        visit "/"
        page.should have_content("Owl")
    end
end
