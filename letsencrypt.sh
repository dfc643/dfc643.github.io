#!/bin/bash

/root/.acme.sh/acme.sh issue /home/dfc643/private_acme fcsys.org www.fcsys.org,b.fcsys.org,blog.fcsys.org,lib.fcsys.org ec-384

cd /root/.acme.sh/
cat fcsys.org_ecc/fcsys.org.cer fcsys.org_ecc/fcsys.org.csr fcsys.org_ecc/ca.cer > fcsys.org_ecc/fcsys.org.crt

nginx -s reload
