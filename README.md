# JMS URL Rewrite Rule

It is a WordPress plugin which is also tracked in WordPress svn repository.

## Keep SVN Pure

In git repository, please keep all files and folders, even empty folders, from svn repository, including `.svn`. To avoid adding git files to svn, please run following commands on MacOS:

```bash
export SVN_EDITOR=vi
svn propedit svn:ignore .
```

After opening the vi editor, please add following content. The content may vary according your real case.

```bash
.git
.gitignore
LICENSE
README.md
```

## Keep All SVN Files in Git

To keep 3 empty folders `assets`, `branches`, `tags` in git repository, please create an empty `.gitignore` file in each folder, as these 3 folders are highly likely empty for most of the WordPress plugin project. After creating the file, please run following commands to ignore this file in svn.

```bash
svn propset svn:ignore '.gitignore' assets
svn propset svn:ignore '.gitignore' branches
svn propset svn:ignore '.gitignore' tags
```

## SVN Help

`svn checkout url`
`svn status`
`svn commit`