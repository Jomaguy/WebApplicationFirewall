#!/usr/bin/python3
from sklearn.feature_extraction.text import TfidfVectorizer
import os
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LogisticRegression
from sklearn import metrics
import urllib.parse

import matplotlib.pyplot as plt

def loadFile(name):
    directory = str(os.getcwd())
    filepath = os.path.join(directory,name)
    with open(filepath, 'r') as f:
        data = f.readlines()
    data = list(set(data))
    result = []
    for d in data:
        d = str(urllib.parse.unquote(d))
        result.append(d)
    return result

badQueries = loadFile('badqueries.txt')
validQueries = loadFile('goodqueries.txt')

badQueries = list(set(badQueries))
validQueries = list(set(validQueries))
allQueries = badQueries + validQueries
yBad = [1 for i in range(0, len(badQueries))]
yGood = [0 for i in range(0, len(validQueries))]
y = yBad + yGood
queries = allQueries

vectorizer = TfidfVectorizer(min_df = 0.0, analyzer = "char", sublinear_tf = True, ngram_range = (1,3)) 
X = vectorizer.fit_transform(queries)


test = loadFile('test.txt')

hofstra = list(set("https://www.hofstra.edu"))
result = []
for d in test:
    d = str(urllib.parse.unquote(d))
    result.append(d)


Y = vectorizer.transform(result)

X_Train, X_Test, y_train, y_test = train_test_split(X, y, test_size = 0.2, random_state = 42)

badCount = len(badQueries)
validCount = len(validQueries)

lgs = LogisticRegression(max_iter = 200, class_weight = 'balanced')
lgs.fit(X_Train, y_train)

predicted = lgs.predict(X_Test)


fpr, tpr, _ = metrics.roc_curve(y_test, (lgs.predict_proba(X_Test)[:,1]))
auc = metrics.auc(fpr, tpr)

print("Bad samples : %d" % badCount)
print("Good sample : %d" % validCount)
print("Baseline Constant Negative: %.6f" % (validCount / (validCount + badCount)))
print("-------------")
print("Accuracy: % f" % lgs.score(X_Test, y_test))
print("Precision: %f" % metrics.precision_score(y_test, predicted))
print("Recall: %f" % metrics.recall_score(y_test,predicted))
print("F1-score: %f" % metrics.f1_score(y_test,predicted))
print("AUC: %f" % auc)

