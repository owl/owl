# encoding: utf-8

require File.dirname(__FILE__)+'/spec_helper'

describe 'item page index', :js => true do
    it 'access item page index' do
        login
        visit "/items/"
        page.should have_content("情報を共有しよう")
    end
end

describe 'item create', :js => true do
    it 'access item page index' do
        login
        visit "/items/create"
        fill_in('title', :with => 'Test Title')
        testBody  = "test body\n";
        testBody += "![test_image_alt1](//test.jpg)\n";
        testBody += "![test_image_alt2](//test.jpg \"test_image_title2\")\n";
        testBody += "![test_image_alt3](//test.jpg =250x200)\n";
        testBody += "![test_image_alt4](//test.jpg =x200)\n";
        testBody += "![test_image_alt5](//test.jpg =250x)\n";
        testBody += "![test_image_alt6](//test.jpg \"test_image_title6\" =250x200)\n";
        fill_in('body',  :with => testBody)
        click_on('投稿')
        click_link('Test Title')
        page.find(:xpath, "//img[@alt='test_image_alt1']")
        page.find(:xpath, "//img[@alt='test_image_alt2'][@title='test_image_title2']")
        page.find(:xpath, "//img[@alt='test_image_alt3'][@height='250'][@width='200']")
        page.find(:xpath, "//img[@alt='test_image_alt4'][@width='200']")
        page.find(:xpath, "//img[@alt='test_image_alt5'][@height='250']")
        page.find(:xpath, "//img[@alt='test_image_alt6'][@title='test_image_title6']")
    end

end

describe 'item delete', :js => true do
    it 'delete item' do
        login
        visit "/items/"
        click_link('Test Title')
        click_link('削除')
    end
end
