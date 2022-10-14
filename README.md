<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sistema de assinatura Laravel/Cashier

Sistema de assinatura feito em laravel e com o Cashier abstraindo o stripe. Um usuário assina um plano e o stripe se encarregada do resto : )

## O que você encontrará?
- integração com o stripe para sistema de assinaturas
- routes, model, views, controller, migrations
- middlewares
- webhook para o stripe enviar informações sobre o estado do usuário (cancelou, assinou, reembolsou...)
- login e autenticação com o breeze
- tailwindcss
- blade
# funcionalidades do usuário: 
- assinar um plano
- cancelar um plano
- fazer upgrade de plano pagando somente a diferença de preço entre os planos
- pedir reembolso
- gerar/imprimir/baixar fatura
- gerar/imprimir/baixar recibos
- receber email sobre pagamentos, reembolsos e cancelamentos
- atualizar endereço de cobrança caso compre algo físico


