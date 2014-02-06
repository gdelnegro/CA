README
======

Instalação:

Mover o diretório casasul para seu servidor web;

Criar um VHost em seu servidor, e apontar o index para o diretório /casasul/public/

Executar o script 'criar.sql', presente na pasta MER, em seu MySQL, com o usuário Root

Dar permissão de escrita na pasta "/public/images/" e suas subpastas. local onde serão enviadas as imagens do site.

Para servidores linux:
Mudar o dono do diretório onde foi colocado o site, para o usuário do servidor web.