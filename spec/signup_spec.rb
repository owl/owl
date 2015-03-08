#!/bin/env ruby
# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'
require 'securerandom'

describe 'Signup' do

    def input_and_submit_user_info
        visit "/signup"
        testUsername = SecureRandom.hex(8)
        fill_in('username', :with => testUsername)
        testEmail  = testUsername;
        testEmail += "@example.com";
        fill_in('email', :with => testEmail)
        fill_in('password', :with => 'password')
        yield if block_given?
        click_on('登録')
    end

    describe 'Smoke Test', :js => true do
        context 'when access the signup page.(not logged in)' do
            it 'will redirect login page' do
                visit "/signup"
                expect(page).to have_content '新規登録'
            end
        end
        context 'when access the signup page.(logged in)' do
            it 'will redirect top page' do
                login
                visit "/signup"
                expect(page).to have_content '投稿する'
            end
        end
    end

    describe 'create user', :js => true do
        context 'fill in all with correct params' do
            it 'is valid' do
                input_and_submit_user_info
                expect(page).to have_content '登録が完了しました'
            end
        end
    end

    describe 'validation', :js => true do
        context 'fill in with empty params' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'username', with: ''
                    fill_in 'email', with: ''
                    fill_in 'password', with: ''
                end
                expect(page).to have_content 'ユーザ名は必須です'
                expect(page).to have_content 'Emailは必須です'
                expect(page).to have_content 'パスワードは必須です'
            end
        end
        context 'fill in with username which katakana' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'username', with: 'カタカナ'
                end
                expect(page).to have_content 'ユーザ名にはアルファベット、数字以外使用できません'
            end
        end
        context 'fill in with username which reserved word' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'username', with: 'item'
                end
                expect(page).to have_content 'このユーザ名を使用することはできません'
            end
        end
        context 'fill in with username which over 30 characters' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'username', with: 'llllllllllllllllllllllllllllll31'
                end
                expect(page).to have_content 'ユーザ名の長さは30文字以下である必要があります'
            end
        end
        context 'fill in with username which already exists' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'username', with: 'admin'
                end
                expect(page).to have_content 'このユーザ名を使用することはできません'
            end
        end
        context 'fill in with email which email-style' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'email', with: 'testtesttest'
                end
                expect(page).to have_content 'このEmailは正しいメールアドレスではありません'
            end
        end
        context 'fill in with email which already exists' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'email', with: 'admin@example.com'
                end
                expect(page).to have_content 'このEmailはすでに使われています'
            end
        end
        context 'fill in with password which katakana' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'password', with: 'パスワード'
                end
                expect(page).to have_content 'パスワードにはアルファベット、数字以外使用できません'
            end
        end
        context 'fill in with password which under 4 characters' do
            it 'is invalid' do
                input_and_submit_user_info do
                    fill_in 'password', with: 'abc'
                end
                expect(page).to have_content 'パスワードの長さは 4文字以上である必要があります'
            end
        end
    end
end
