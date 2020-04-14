<?php

declare(strict_types=1);

namespace Deployer;

desc('Compile styles');
task('compile:styles', function () {
    run('ln -sfn /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix/node_modules "/opt/atlassian/pipelines/agent/build/app/design/frontend/JustBetter/runningshop/node_modules');
    run('ln -sfn /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix/node_modules "/opt/atlassian/pipelines/agent/build/app/design/frontend/JustBetter/21run/node_modules"');
    run('yarn install --cwd /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix  --frozen-lockfile --ignore-engines');
    run('set -o allexport; source /opt/atlassian/pipelines/agent/build/.env; set +o allexport && yarn --cwd /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix run nocritical-prod');
    run('set -o allexport; source /opt/atlassian/pipelines/agent/build/.env; set +o allexport && yarn --cwd /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix run email-production');
});
