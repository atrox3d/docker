# error  - URL e parameter need to be quotes separately
# errore - URL e parametro devono essere messi tra virgolette separatamente
curl -XGET 'http://localhost:9200/megacorp/employee/_search -d {
    "query" : {
        "match" : {
            "last_name" : "Smith"
        }
    }
}'


# error  - parameter needs to start before new line
# errore - il parametro deve cominciare prima di LF
curl -XGET 'http://localhost:9200/megacorp/employee/_search' -d 
'{
    "query" : {
        "match" : {
            "last_name" : "Smith"
        }
    }
}'

# ok
curl -XGET 'http://localhost:9200/megacorp/employee/_search' -d '{
    "query" : {
        "match" : {
            "last_name" : "Smith"
        }
    }
}'

#pretty
curl -XGET 'http://localhost:9200/megacorp/employee/_search?pretty' -d '{
    "query" : {
        "match" : {
            "last_name" : "Smith"
        }
    }
}'
