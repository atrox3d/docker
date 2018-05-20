curl -X DELETE "http://192.168.99.100:9200/ecommerce/category/_query?pretty" 
-H 'Content-Type: application/json' -d'
{
  "query": {
    "term": {
      "name": "cleaning"
    }
  }
}
'

