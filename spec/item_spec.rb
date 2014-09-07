# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'Item' do

    def input_and_submit_items
        login
        visit "/items/create"
        fill_in('title', :with => 'Test Title')
        fill_in('body',  :with => 'Test Body')
        yield if block_given?
        click_on('投稿')
    end


    describe 'Smoke Test', :js => true do
        context 'when access the index page.(not logged in)' do
            it 'will redirect login page' do
                visit "/items"
                expect(page).to have_content 'ログイン'
            end
        end
        context 'when access the index page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/items"
                expect(page).to have_content 'すべての投稿'
            end
        end
        context 'when access the create page.(logged in)' do
            it 'will be displayed' do
                login
                visit "/items/create"
                expect(page).to have_content '新規投稿'
            end
        end
    end

    describe 'CRUD', :js => true do
        context 'When create item' do
            it 'is true' do
                input_and_submit_items do
                    testBody  = "test body\n";
                    testBody += "![test_image_alt1](" + Capybara.app_host + "/img/owl_logo_mini.png)\n";
                    testBody += "![test_image_alt2](" + Capybara.app_host + "/img/owl_logo_mini.png \"test_image_title2\")\n";
                    testBody += "![test_image_alt3](" + Capybara.app_host + "/img/owl_logo_mini.png =250x200)\n";
                    testBody += "![test_image_alt4](" + Capybara.app_host + "/img/owl_logo_mini.png =x200)\n";
                    testBody += "![test_image_alt5](" + Capybara.app_host + "/img/owl_logo_mini.png =250x)\n";
                    testBody += "![test_image_alt6](" + Capybara.app_host + "/img/owl_logo_mini.png \"test_image_title6\" =250x200)\n";
                    fill_in('body',  :with => testBody)
                end
                click_link('Test Title', :match => :first)
                page.find(:xpath, "//img[@alt='test_image_alt1']")
                page.find(:xpath, "//img[@alt='test_image_alt2'][@title='test_image_title2']")
                page.find(:xpath, "//img[@alt='test_image_alt3'][@height='250'][@width='200']")
                page.find(:xpath, "//img[@alt='test_image_alt4'][@width='200']")
                page.find(:xpath, "//img[@alt='test_image_alt5'][@height='250']")
                page.find(:xpath, "//img[@alt='test_image_alt6'][@title='test_image_title6']")
            end
        end
        context 'When update item' do
            it 'is true' do
                login
                visit "/items/"
                click_link('Test Title', :match => :first)
                click_link('編集')
                fill_in('title', :with => 'Update Test')
                testBody = "test body\n";
                testBody = "![test_image_alt7](" + Capybara.app_host + "/img/owl_logo_mini.png \"test_image_title7\" =250x200)\n";
                fill_in('body',  :with => testBody)
                click_on('投稿')
                page.find(:xpath, "//img[@alt='test_image_alt7'][@title='test_image_title7']")
            end
        end
        context 'When click the like button' do
            it 'is true' do
                login
                visit "/items/"
                click_link('Update Test', :match => :first)
                click_link('いいね！', :match => :first)
                visit current_path
                expect(page).to have_css('#unlike_id')
            end
        end
        context 'When click the unlike button' do
            it 'is true' do
                login
                visit "/items/"
                click_link('Update Test', :match => :first)
                click_link('いいね！を取り消す', :match => :first)
                visit current_path
                expect(page).to have_css('#like_id')
            end
        end
        context 'When post a comment' do
            it 'is true' do
                login
                visit "/items/"
                click_link('Update Test', :match => :first)
                fill_in('body', :with => 'test comment')
                click_button('投稿する', :match => :first)
                expect(page).to have_content 'test comment'
            end
        end
        context 'When update a comment' do
            it 'is true' do
                login
                visit "/items/"
                click_link('Update Test', :match => :first)
                within("#comment-container") do
                      click_link('編集')
                end
                fill_in('body', :with => 'update comment', :match => :first)
                click_button('編集', :match => :first)
                expect(page).to have_content 'update comment'
            end
        end
        context 'When delete a comment' do
            it 'is true' do
                login
                visit "/items/"
                click_link('Update Test', :match => :first)
                within("#comment-container") do
                      click_link('削除')
                end
                expect(page).to have_no_content 'update comment'
            end
        end
        context 'When delete item' do
            it 'is true' do
                login
                visit "/items/"
                click_link('Update Test', :match => :first)
                click_link('削除')
                expect(current_path).to eq '/items'
            end
        end
    end

    describe 'validation', :js => true do
        context 'fill in with empty params' do
            it 'is invalid' do
                input_and_submit_items do
                    fill_in 'title', with: ''
                    fill_in 'body', with: ''
                end
                expect(page).to have_content 'タイトルは必須です'
                expect(page).to have_content '本文は必須です'
            end
        end
        context 'fill in with title which over 255 characters' do
            it 'is invalid' do
                input_and_submit_items do
                    fill_in 'title', with: 'llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll'
                end
                expect(page).to have_content 'タイトルの長さは255文字以下である必要があります'
            end
        end
    end
end
