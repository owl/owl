#!/bin/env ruby
# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'login page', :js => true do
    it 'access login page' do
        visit "/login"
        page.should have_content("Owl")
    end
end

describe 'login page', :js => true do
    it 'can login with correct user' do
        visit "/login/"
        fill_in('username', :with => 'admin')
        fill_in('password', :with => 'password')
        click_on('ログイン')

        page.should have_content("投稿する")
    end
end

describe 'login page', :js => true do
    it 'cant login with wrong user' do
        visit "/login/"
        fill_in('username', :with => 'testtesttest')
        fill_in('password', :with => 'password')
        click_on('ログイン')

        page.should have_content("ユーザ名又はパスワードが正しくありません")
    end
end
