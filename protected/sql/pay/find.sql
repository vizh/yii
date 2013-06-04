SELECT * FROM "PayLog"

WHERE "PayLog"."OrderId" IN (
SELECT "PayLog"."OrderId" FROM "PayLog"

LEFT JOIN "PayOrder" ON "PayOrder"."Id" = "PayLog"."OrderId"

WHERE "PayOrder"."EventId" = 497

GROUP BY "PayLog"."OrderId"

HAVING "count"("PayLog"."OrderId") = 2)

ORDER BY "PayLog"."OrderId"