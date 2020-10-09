-- -- Works
-- SELECT
--     CategoryName,
--     Ammount,
--     SumOfAmmount,
--     Ammount - SumOfAmmount 
-- FROM (
--     SELECT
--         Categories.CategoryName,
--         Categories.Ammount, 
--         IFNULL(Sum(SpendingTransactions.Ammount), 0) AS SumOfAmmount
--     FROM
--         Categories 
--     LEFT JOIN SpendingTransactions ON Categories.CategoryName = SpendingTransactions.Category
--     GROUP BY
--     Categories.CategoryName,
--     Categories.Ammount
-- ) AS budget;

-- -- Works with totals
-- SELECT
--     CategoryName,
--     Ammount,
--     SumOfAmmount,
--     Ammount - SumOfAmmount AS Leftover
-- FROM (
--     SELECT
--         Categories.CategoryName,
--         Categories.Ammount, 
--         IFNULL(Sum(SpendingTransactions.Ammount), 0) AS SumOfAmmount
--     FROM
--         Categories 
--     LEFT JOIN SpendingTransactions ON Categories.CategoryName = SpendingTransactions.Category
--     GROUP BY
--     Categories.CategoryName,
--     Categories.Ammount
-- ) AS budget
-- UNION SELECT
--     "Total" AS CategoryName,
--     Sum(Ammount) AS Ammount,
--     Sum(SumOfAmmount) AS SumOfAmmount,
--     Sum(Ammount - SumOfAmmount) AS Leftover
-- FROM (
--     SELECT
--         Categories.CategoryName,
--         Categories.Ammount, 
--         IFNULL(Sum(SpendingTransactions.Ammount), 0) AS SumOfAmmount
--     FROM
--         Categories 
--     LEFT JOIN SpendingTransactions ON Categories.CategoryName = SpendingTransactions.Category
--     GROUP BY
--     Categories.CategoryName,
--     Categories.Ammount
-- ) AS budget




-- new shit
SELECT
	Category,
	Ammount,
	Total_Spent,
	Total_Spent - Ammount AS Difference
FROM (
	SELECT
		PersonalBudgetCategories.Category,
		PersonalBudgetCategories.Ammount,
		IFNULL(SUM(SpendingTransactions.Ammount), 0) AS Total_Spent
	FROM (
		SELECT
			Category,
			Ammount
		FROM
			BudgetCategories
		WHERE
		BudgetID = 1
	) AS PersonalBudgetCategories LEFT JOIN SpendingTransactions ON PersonalBudgetCategories.Category = SpendingTransactions.Category
	GROUP BY
		PersonalBudgetCategories.Category,
		PersonalBudgetCategories.Ammount
) AS Budget
UNION SELECT
	"Total" AS Category,
	SUM(Ammount) AS Ammount,
	SUM(Total_Spent) AS Total_Spent,
	SUM(Difference) AS Difference
FROM (
	SELECT
		Category,
		Ammount,
		Total_Spent,
		Total_Spent - Ammount AS Difference
	FROM (
		SELECT
			PersonalBudgetCategories.Category,
			PersonalBudgetCategories.Ammount,
			IFNULL(SUM(SpendingTransactions.Ammount), 0) AS Total_Spent
		FROM (
			SELECT
				Category,
				Ammount
			FROM
				BudgetCategories
			WHERE
			BudgetID = 1
		) AS PersonalBudgetCategories LEFT JOIN SpendingTransactions ON PersonalBudgetCategories.Category = SpendingTransactions.Category
		GROUP BY
			PersonalBudgetCategories.Category,
			PersonalBudgetCategories.Ammount
	) AS Budget
) AS TotalsBudget;










SELECT
	Category,
	Ammount,
	Total_Spent,
	Total_Spent - Ammount AS Difference
FROM (
	SELECT
		PersonalBudgetCategories.Category,
		PersonalBudgetCategories.Ammount,
		IFNULL(SUM(SpendingTransactions.Ammount), 0) AS Total_Spent
	FROM (
		SELECT
			Category,
			Ammount
		FROM
			BudgetCategories
		WHERE
		BudgetID = 1
	) AS PersonalBudgetCategories LEFT JOIN SpendingTransactions ON PersonalBudgetCategories.Category = SpendingTransactions.Category
	GROUP BY
		PersonalBudgetCategories.Category,
		PersonalBudgetCategories.Ammount
) AS Budget;