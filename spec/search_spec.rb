# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'Search' do

    describe 'Smoke Test', :js => true do
        context 'when access the index page.(not logged in)' do
            it 'will be displayed' do
                visit "/search?q=testtesttest"
                expect(page).to have_content '検索結果'
            end
        end
        context 'when access the index page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/search?q=testtesttest"
                expect(page).to have_content '検索結果'
            end
        end
    end
end
