# 开发笔记

官方文档：https://hyperf.wiki/2.2/#/zh-cn/annotation

### 异步队列

queueService

### 注解

通过注解方式绑定发送的消息

```php
/**
  * @AsyncQueueMessage(delay=10)
  */
public function example($params)
{
    // TODO: Implement handle() method.
    return 'success';
}
```

