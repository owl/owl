Feature: Template Test
    tests for templates/* pages.

    # Smoke test
    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/templates"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/templates"
        Then I should be on "/templates"
        Then I should see "テンプレート一覧"
        Then the response status code should be 200

    Scenario: Smoke test (not logged in)
        Given I am on the homepage
        When I go to "/templates/create"
        Then I should be on "/login"
        Then I should see "ログイン"
        Then the response status code should be 200

    Scenario: Smoke test (logged in)
        Given I am on the homepage
        When I logged in
        When I go to "/templates/create"
        Then I should be on "/templates/create"
        Then I should see "テンプレート作成"
        Then the response status code should be 200

