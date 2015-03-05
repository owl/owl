# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'Stock' do

    describe 'Smoke Test', :js => true do
        context 'when access the index page.(not logged in)' do
            it 'will redirect login page' do
                visit "/stocks"
                expect(page).to have_content 'ログイン'
            end
        end
        context 'when access the index page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/stocks"
                expect(page).to have_content 'ストック一覧'
            end
        end
    end
end
