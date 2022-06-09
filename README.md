# Módulo para inserção de tag em instalações Multi Sites
Para realizar a instalação é necessário apenas inserir os arquivos do módulo dentro da pasta raiz de instalação do Magento, seguindo as estruturas (app/code)

A ideia da extensão é inserir uma tag especifica apenas nas páginas CMS cadastradas na plataforma, levando em consideração em quais visões da loja essa página CMS está configurada.

A extensão insere um arquivo phtml no head em todas as páginas do Magento, porém, a tag é inserida apenas em páginas CMS.
1º Primeiro é verificado se a extensão está habilitada e se a página atual é uma página CMS
2º É retornado todas as páginas CMS, verificando se a página atual está na collection de páginas, caso sim, recupero o idioma da visão e faço a inserção da tag, seguindo o padrão abaixo:
<link rel="alternate" hreflang="idioma" href="baseurl/cmsatual">
