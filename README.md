## Deployment
- `make up` - сборка и запуск 
- `make sh` - переход в консоль php контейнера
- `bin/console doctrine:migrations:migrate` - проведение миграций
- `bin/console app:generate-initial-data` - генерация кошельков
- `make down` - остановка

## Using
- `bin/console app:generate-initial-data` - генерация кошельков
- `bin/console app:update-exchange-rates` - обновление курсов
- `[GET] https://localhost/wallet/{walletId}` - запрос баланса кошелька
- `[POST] https://localhost/transaction` - проведение транзакции
 ```json
{
    "walletId": 132,
    "type": "DEBIT",
    "amount": 1.12,
    "currency": "USD",
    "reason": "REFUND"
}
```
## Todo
- Фабрики для генерации VO и моделей
- Специфицировать все exceptions
- Генератор данных - генерация на основе транзакций
- MoneyVO - применение BC Math или moneyphp/money

## SQL
Запрос ниже актуален в случае хранения транзакций (balance_changes) в USD (
с применением обработчика USDBalanceChangeMakerMoneyService)
```sql
SELECT SUM(bc.amount) as sum
FROM balance_change bc
WHERE bc.change_reason='REFUND'
    AND created_at >= (now() - interval '1 week');
```

По запросу и связанной с ним бизнес-логикой - зависит от задачи, поскольку сам 
по себе он, в контексте различных валют и разных кошельков, смысла не имеет. 
Также это аффектит применяемые индексы.
- В случае, если требуется выборка по определенным кошелькам, первым полем в 
индексе (created_at + change_reason) для balance_change будет id кошелька, как
наиболее селективное;
- В случае, если хотим работать со статистикой по разным кошелькам, имеет смысл
хранить данные по balance_change в определенной наиболее часто запрашиваемой 
валюте, индекс по wallet_id в таком случае будет избыточным;
- Если предполагаются запросы "50/50", вероятно, имело бы смысл внедрить 
какую-то materialized view, с результатами расчетов в единую валюту. При этом, 
в balance_change оставались бы записи в нативной валюте кошелька.
