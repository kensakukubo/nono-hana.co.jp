#!/bin/bash
echo "デプロイ開始..."
rsync -avz -e "ssh -p 10022" \
  ~/nono-hana.co.jp/grouphome/wp-content/themes/grouphome/ \
  xs710041@xs710041.xsrv.jp:/home/xs710041/nono-hana.co.jp/public_html/grouphome/wp-content/themes/grouphome/
echo "デプロイ完了！"
