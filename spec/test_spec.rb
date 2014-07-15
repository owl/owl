#!/bin/env ruby
# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'テスト', :js => true do
    it 'トップページ' do
        visit "/"
        page.should have_content("Athena")
    end
end
