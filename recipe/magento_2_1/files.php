<?php

declare(strict_types=1);

/* (c) Juan Alonso <juan.jalogut@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer;

set('languages', 'en_US');
set('static_deploy_options', '--exclude-theme=Magento/blank');

task('files:compile', '{{bin/php}} {{magento_bin}} setup:di:compile');
task('files:static_assets', '{{bin/php}} {{magento_bin}} setup:static-content:deploy {{languages}} {{static_deploy_options}}');
task(
    'files:permissions',
    'cd {{magento_dir}} && chmod -R g+w var vendor pub/static pub/media app/etc && chmod u+x bin/magento'
);

task('files:styling', function(){
    run('ln -sfn /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix/node_modules "/opt/atlassian/pipelines/agent/build/app/design/frontend/JustBetter/runningshop/node_modules');
    run('ln -sfn /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix/node_modules "/opt/atlassian/pipelines/agent/build/app/design/frontend/JustBetter/21run/node_modules"');
    run('yarn install --cwd /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix  --frozen-lockfile --ignore-engines');
    run('set -o allexport; source /opt/atlassian/pipelines/agent/build/.env; set +o allexport && yarn --cwd /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix run nocritical-prod');
    run('set -o allexport; source /opt/atlassian/pipelines/agent/build/.env; set +o allexport && yarn --cwd /opt/atlassian/pipelines/agent/build/vendor/justbetter/magento2mix run email-production');
});

desc('Generate Magento Files');
task('files:generate', [
    'files:compile',
    'files:styles',
    'files:static_assets',
    'files:permissions',
]);
