# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'User' do

    describe 'Smoke Test', :js => true do
        context 'when access the index page.(not logged in)' do
            it 'will redirect login page' do
                visit "/admin"
                expect(page).to have_content 'ログイン'
            end
        end
        context 'when access the show page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/admin"
                expect(page).to have_content 'プロフィール'
            end
        end
        context 'when access the edit page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/user/edit"
                expect(page).to have_content 'アカウント設定'
            end
        end
    end
end
