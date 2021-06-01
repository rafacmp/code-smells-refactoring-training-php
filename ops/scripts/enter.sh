#!/bin/bash

COMPONENT=${7}
CONTAINERS=$(docker ps --no-trunc -f "name=${COMPONENT}" --format "{{.Names}}")

if [[ ${#CONTAINERS[@]} -eq 0 ]]; then
  echo "ERROR: No running containers found"
  exit 1
fi

printf "
  Write the name of the service that you want to access, possible choices are:\n\n"
for CONTAINER in ${CONTAINERS}; do
  echo "    * ${CONTAINER}"
done

printf "\nService name: " && read -r SERVICE

docker exec -ti -u root ${SERVICE} /bin/sh
