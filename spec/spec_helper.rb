# 設定
# encoding: utf-8
require 'capybara/rspec'
require 'capybara/poltergeist'

begin
  include Capybara::DSL
rescue
  include Capybara
end

# アプリケーション設定
Capybara.app = "athena"
Capybara.javascript_driver = :poltergeist
Capybara.app_host = 'http://0.0.0.0:3000'
Capybara.run_server = false
