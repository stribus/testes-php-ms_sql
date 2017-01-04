
CREATE TABLE [dbo].[SENHAS_SEGURADOS](
	[COD_SEG] [int] NOT NULL,
	[SENHA] [nvarchar](128) NULL,
 CONSTRAINT [PK_SENHAS_SEGURADOS] PRIMARY KEY CLUSTERED 
(
	[COD_SEG] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO


CREATE VIEW [dbo].[VW_LOGIN]
AS
SELECT     S.COD_SEG, S.CGC, S.COD_INSS, S.MAIL, SS.SENHA
FROM         previsul.dbo.SEGURADOS AS S LEFT OUTER JOIN
                      dbo.SENHAS_SEGURADOS AS SS ON S.COD_SEG = SS.COD_SEG

GO