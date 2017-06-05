SELECT
	"count"("UserEmployment"."Id"),
	"UserEmployment"."CompanyId"
FROM "UserEmployment"

	LEFT JOIN "EventParticipant" ON "UserEmployment"."UserId" = "EventParticipant"."UserId"


WHERE "EventParticipant"."EventId" = 422 AND "UserEmployment"."Primary"

GROUP BY "UserEmployment"."CompanyId"

ORDER BY "count"("UserEmployment"."Id") DESC

LIMIT 50