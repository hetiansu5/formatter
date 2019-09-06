#!bin/bash
# 执行单元测试
vendor/bin/phpunit --configuration phpunit.xml --colors tests;

# 生成单元测试覆盖率报告
#vendor/bin/phpunit --bootstrap vendor/autoload.php --coverage-html=reports/ --whitelt src/ tests/
# 查看覆盖率报告，浏览器访问http://127.0.0.1:8899
#cd reports/ && php -S 0.0.0.0:8899