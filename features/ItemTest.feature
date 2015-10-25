Feature: Item Test
    tests for item/* pages.

    # Normal Test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/items"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/items"
        Then I should be on "/items"
        Then I should see "すべての投稿"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/items/create"
        Then I should be on "/items/create"
        Then I should see "新規投稿"
        Then the response status code should be 200

    Scenario: Create item
        Given I am on the homepage
        When I logged in
        When I go to "/items/create"
        When I fill in "title" with "Test Title"
        When I fill in "body" with "Test Body"
        When I fill in "tags" with "create"
        When I press "投稿"
        Then I should see "Test Body"
        Then the response status code should be 200

    Scenario: Update item
        Given I am on the homepage
        When I logged in
        When I go to "/items/"
        When I follow "Test Title"
        When I follow "編集"
        When I fill in "title" with "Update Title"
        When I fill in "body" with "Update Body"
        When I fill in "tags" with "update"
        When I press "投稿"
        Then I should see "Update Body"
        Then the response status code should be 200

    Scenario: Item History page
        Given I am on the homepage
        When I logged in
        When I go to "/items/"
        When I follow "Update Title"
        When I follow "変更履歴"
        Then I should see "作成"
        Then the response status code should be 200

    Scenario: Delete Item
        Given I am on the homepage
        When I logged in
        When I go to "/items/"
        When I follow "Update Title"
        When I delete item
        Then I should be on "/items"
        Then I should see "すべての投稿"
        Then the response status code should be 200

    # Abnormal Test
    Scenario: validation error when fill in with empty params
        Given I am on the homepage
        When I logged in
        When I go to "/items/create"
        When I fill in "title" with ""
        When I fill in "body" with ""
        When I press "投稿"
        Then I should be on "/items/create"
        Then I should see "タイトルは必須です"
        Then I should see "本文は必須です"
        Then the response status code should be 200

    Scenario: validation error when fill in with title which over 255 characters
        Given I am on the homepage
        When I logged in
        When I go to "/items/create"
        When I fill in "title" with "llllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll"
        When I fill in "body" with "Test Body"
        When I press "投稿"
        Then I should be on "/items/create"
        Then I should see "タイトルの長さは255文字以下である必要があります"
        Then the response status code should be 200
