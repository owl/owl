# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'Tag' do

    describe 'Smoke Test', :js => true do
        context 'when access the index page.(not logged in)' do
            it 'will redirect login page' do
                visit "/tags"
                expect(page).to have_content 'ログイン'
            end
        end
        context 'when access the show page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/tags/testtag"
                expect(page).to have_content 'タグの記事'
            end
        end
    end
end
