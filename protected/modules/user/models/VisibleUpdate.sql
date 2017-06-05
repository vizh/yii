UPDATE "User" AS u
SET "Visible" = us."Visible"

FROM "UserSettings" AS us

WHERE u."Id" = us."UserId"