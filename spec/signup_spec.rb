#!/bin/env ruby
# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'
require 'securerandom'

describe 'signup page', :js => true do
    it 'access signup page' do
        visit "/signup"
        page.should have_content("新規ユーザー登録")
    end
end

describe 'signup page', :js => true do
    it 'can signup with valid values' do
        visit "/signup"
        testUsername = SecureRandom.hex(8)
        fill_in('username', :with => testUsername)
        testEmail  = testUsername;
        testEmail += "@example.com";
        fill_in('email', :with => testEmail)
        fill_in('password', :with => 'password')
        click_on('登録')

        page.should have_content("登録が完了しました。")
    end
end

describe 'signup page', :js => true do
    it 'cant signup with invalid values' do
        visit "/signup"
        testUsername = SecureRandom.hex(8)
        fill_in('username', :with => 'test')
        fill_in('email', :with => 'aa')
        fill_in('password', :with => 'aa')
        click_on('登録')

        page.should have_css('.alert-warning')
    end
end
