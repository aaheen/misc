# Fetches all git repos in my home code directory.

set EAH {$HOME}/code/src/github.com/eaheen

cd {$EAH}

for repo in {$EAH}/*
  cd {$repo}
  echo Fetching repo {$repo}...
  git fetch
end
