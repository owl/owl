#!/bin/env ruby
# encoding: utf-8
require 'capybara/rspec'
require 'capybara/poltergeist'


module ::RSpec::Core
    class ExampleGroup
        include Capybara::DSL
    end
end


# アプリケーション設定
Capybara.app = "athena"
Capybara.javascript_driver = :poltergeist
Capybara.app_host = 'http://0.0.0.0:3000'
Capybara.run_server = false
Capybara.register_driver :poltergeist do |app|
    Capybara::Poltergeist::Driver.new(app, :js_errors => false, :timeout => 60)
end

def login
    visit "/login/"
    fill_in('username', :with => 'admin')
    fill_in('password', :with => 'password')
    click_on('ログイン')
end
