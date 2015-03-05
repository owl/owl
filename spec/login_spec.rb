#!/bin/env ruby
# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'Login' do
    describe 'Smoke Test', :js => true do
        context 'when access the top page.(not logged in)' do
            it 'will redirect login page' do
                visit "/"
                expect(page).to have_content 'ログイン'
            end
        end
        context 'when access the top page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/"
                expect(page).to have_content '投稿する'
            end
        end
        context 'when access the login page.(not logged in)' do
            it 'will be displayed' do
                visit "/login"
                expect(page).to have_content 'ログイン'
            end
        end
        context 'when access the login page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/login"
                expect(page).to have_content '投稿する'
            end
        end
    end

    describe 'validation', :js => true do
        context 'fill in with wrong username' do
            it 'is invalid' do
                visit "/login/"
                fill_in('username', :with => 'testtesttest')
                fill_in('password', :with => 'password')
                click_on('ログイン')
                expect(page).to have_content 'ユーザ名又はパスワードが正しくありません'
            end
        end
        context 'fill in with only username' do
            it 'is invalid' do
                visit "/login/"
                fill_in('username', :with => 'testtesttest')
                fill_in('password', :with => '')
                click_on('ログイン')
                expect(page).to have_content 'パスワードは必須です。'
            end
        end
        context 'fill in with empty params' do
            it 'is invalid' do
                visit "/login/"
                fill_in('username', :with => '')
                fill_in('password', :with => '')
                click_on('ログイン')
                expect(page).to have_content 'ユーザ名は必須です。'
                expect(page).to have_content 'パスワードは必須です。'
            end
        end
    end
end
