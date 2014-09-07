# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'Template' do

    describe 'Smoke Test', :js => true do
        context 'when access the index page.(not logged in)' do
            it 'will redirect login page' do
                visit "/templates"
                expect(page).to have_content 'ログイン'
            end
        end
        context 'when access the index page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/templates"
                expect(page).to have_content 'テンプレート一覧'
            end
        end
        context 'when access the create page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/templates/create"
                expect(page).to have_content 'テンプレート作成'
            end
        end
    end
end
