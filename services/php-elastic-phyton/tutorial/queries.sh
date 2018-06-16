#!/bin/bash
SERVER=http://localhost:9200
INDEX=megacorp
TYPE=employee
ENDPOINT=${SERVER}/${INDEX}/${TYPE}

curl -i -XGET ${ENDPOINT}/_search?pretty

curl -i -XGET ${ENDPOINT}'/_search?&pretty=true&q=last_name=smith'

curl -XGET '${ENDPOINT}/_search?pretty' -d '{
    query : {
        match : {
            last_name : Smith
        }
    }
}'

curl -XGET '${ENDPOINT}/_search?pretty' -d '{
    query : {
        bool : {
            must : {
                match : {
                    last_name : smith
                }
            },
            filter : {
                range : {
                    age : { gt : 30 }
                }
            }
        }
    }
}'

curl -XGET '${ENDPOINT}/_search?pretty' -d '
{
  query : {
    match : {
      about : rock climbing
    }
  }
}'

curl -XGET '${ENDPOINT}/_search?pretty' -d '
{
    query : {
        match_phrase : {
            about : rock climbing
        }
    }
}'

curl -XGET '${ENDPOINT}/_search?pretty' -d '
{
    query : {
        match_phrase : {
            about : rock climbing
        }
    },
    highlight: {
        fields : {
            about : {}
        }
    }
}'

curl -XGET '${ENDPOINT}/_search?pretty' -d '
{
  aggs: {
    all_interests: {
      terms: { field: interests }
    }
  }
}
'

curl -XGET '${ENDPOINT}/_search?pretty' -d '
{
    aggs : {
        all_interests : {
            terms : { field : interests },
            aggs : {
                avg_age : {
                    avg : { field : age }
                }
            }
        }
    }
}
'
