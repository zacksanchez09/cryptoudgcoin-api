#!/usr/bin/python
# encoding: utf-8

import urllib.request
import numpy as np
import matplotlib.pyplot as plt
import matplotlib.image as mpimg
from kneed import KneeLocator
from sklearn.utils import shuffle
# supress warnings
import warnings
warnings.filterwarnings('ignore')

# Data viz lib
import seaborn as sns
from matplotlib.pyplot import xticks
from sklearn.datasets import make_blobs
from sklearn.cluster import KMeans
from sklearn.metrics import silhouette_score
from sklearn.preprocessing import StandardScaler
from sklearn import preprocessing
from sklearn.preprocessing import LabelEncoder
from sklearn.preprocessing import MinMaxScaler

import yaml
import time
import math
import pandas as pd
import json

class Application:
	vallist = []
	def __init__(self):
		#Liga API principal
		main_api = 'https://cryptoudgcoin.com/api/v1/'
		#Endpoints principales
		sections = ["users", "wallets", "history"]

		with urllib.request.urlopen(main_api+"wallets") as url:
			data_Wallets = url.read()
			df_Wallets = pd.read_json(data_Wallets)
			df_Wallets = df_Wallets.drop(['id','description', 'created_at', 'updated_at', 'decimal_places', 'holder_type'], axis=1)
			df_Wallets['balance_UDGC'] = df_Wallets.apply(self.udgcBalance, axis=1)
			df_Wallets['balance_MXN'] = df_Wallets.apply(self.mxnBalance, axis=1)
			df_Wallets = df_Wallets.replace('None','').groupby('holder_id',as_index=False).agg('sum')
			df_Wallets = df_Wallets.rename(columns={"balance": "balance_Total"})
			df_Wallets['balance_Total'] = df_Wallets['balance_Total'].astype(float)
			pd.set_option("display.max_rows", None, "display.max_columns", None)

		with urllib.request.urlopen(main_api+"users") as url:
			data_Users = url.read()
			df_Users = pd.read_json(data_Users)
			df_Users = df_Users.drop(['name', 'last_name', 'email_verified_at', 'conekta_customer_id', 'created_at', 'updated_at','nip', 'phone', 'email', 'udg_code'], axis=1)
			df_Users = df_Users.sort_values(by='id')
			df_Users = df_Users.reset_index()
			df_Users = df_Users.drop(['index'], axis=1)
			df_Users["career"].fillna("No Estudiante", inplace = True)

		with urllib.request.urlopen(main_api+"history") as url:
			data_History = url.read()
			df_History = pd.read_json(data_History)
			df_History = df_History.drop(['payable_type', 'meta', 'created_at', 'updated_at', 'confirmed', 'uuid'], axis=1)
			df_History = df_History.dropna()

			df_Total = pd.concat([df_Wallets, df_Users], axis = 1)
			df_Total = df_Total.drop(['id', 'holder_id'], axis=1)
			# df_Total.info()

			x = df_Total
			y = df_Total['career']

			le = LabelEncoder()
			x['career'] = le.fit_transform(x['career'])
			y = le.transform(y)

			# x.info()

			cols = x.columns
			ms = MinMaxScaler()

			x = ms.fit_transform(x)
			x = pd.DataFrame(x, columns=[cols])

			kmeans = KMeans(n_clusters=6,random_state=0)

			kmeans.fit(x)

			labels = kmeans.labels_

			# check how many of the samples were correctly labeled
			correct_labels = sum(y == labels)

			cs = []

			for i in range(1, 11):
				kmeans = KMeans(n_clusters = i, init = 'k-means++', max_iter = 300, n_init = 10, random_state = 0)
				kmeans.fit(x)
				cs.append(kmeans.inertia_)

			plt.plot(range(1, 11), cs, markersize=8, lw=2)
			# print(df_Total)

			# plt.grid(True)
			# plt.title('El metodo del codo')
			# plt.xlabel('Numero de Usuarios')
			# plt.ylabel('Inercia')
			# plt.savefig('plots/codo.png')

	def udgcBalance(self, row):
		if row['slug'] == 'udgc_wallet':
			val = row['balance']
		else:
			val = None

		return val

	def mxnBalance(self, row):
		if row['slug'] == 'mxn_wallet':
			val = row['balance']
		else:
			val = None

		return val

application=Application()

